# -*- coding: UTF-8  -*-
## Scrape Wikimedia Commons for Institutions with coordinates
##
## Lokal_Profil
## 2013-04-09
##
## Run using: getList(user=u'Username', filename=u'Outfile.dat')
##
#
import os, codecs, urllib, urllib2, simplejson
from cookielib import CookieJar
from getpass import getpass

def parsePage(wikitext):
	'''parses the wikitext of a page in the Institution namespace and extracts latitude, longitude and website'''
	#Deal with annoying comments
	while wikitext.find(u'<!--') >=0:
			cstart = wikitext.find(u'<!--')
			cend = wikitext.find(u'-->', cstart)
			wikitext=wikitext[:cstart].strip()+wikitext[cend+3:].strip()
	
	params = wikitext.split('|')
	lat,lon,website='','',''
	needCleanup = False
	for p in params:
		p=p.strip()
		pp=p.split('=')
		if p.startswith('latitude'):
			lat = pp[1].strip()
		elif p.startswith('longitude'):
			lon = pp[1].strip()
		elif p.startswith('website'):
			website = pp[1].strip()
			if website.find(u'{{LangSwitch') >=0 or website.find(u'{{langSwitch') >=0:
				needCleanup = True
	if needCleanup:
		website = langCleanup(wikitext)
	if website.startswith('['):
		website=website.split(' ')[0][1:]
	return (lat,lon,website)

def langCleanup(wikitext):
	'''deals with LangSwitch which is somtimes embeded in the website parameter'''
	webBit = wikitext[wikitext.find('website'):]
	webBit = webBit[webBit.find('=')+1:].strip()
	lstart = webBit.find('{{LangSwitch')
	if lstart == -1:
		lstart = webBit.find('{{langSwitch')
	lend =  webBit.find('}}')
	
	webstart = webBit[:lstart]
	webend = webBit[lend+2:].split('|')[0]
	
	langbits = webBit[lstart+len('{{LangSwitch'):lend].split('|')
	langdict = {}
	for l in langbits:
		s = l.find('=')
		if s > 0:
			langdict[l[:s].strip()] = l[s+1:].strip()
	
	webmiddle = ''
	if 'en' in langdict.keys():
		webmiddle = langdict['en']
	elif 'default' in langdict.keys():
		webmiddle = langdict['default']
	
	return webstart+webmiddle+webend

def getPartList(apiurl, opener, apcontinue=''):
	'''gets partial list of all pages in Institution namespace (106)'''
	params = {'action':'query',
			  'prop':'revisions',
			  'format':'json',
			  'rvprop':'content',
			  'generator':'allpages',
			  'gapnamespace':'106',
			  'gaplimit':'500'}
	if len(apcontinue)>0:
		params['gapcontinue'] = urllib2.quote(apcontinue.encode('utf8'))
	query=''
	for k,v in params.iteritems():
		query = '%s&%s=%s' %(query,k,v)
	req = '%s?%s' %(apiurl,query[1:])
	f = opener.open(req).read()
	json = simplejson.loads(f)
	apcontinue='' #reset
	#parse json
	txt=[]
	if u'query-continue' in json.keys():
		apcontinue=json['query-continue']['allpages']['gapcontinue']
	jlist=json['query']['pages']
	for k,v in jlist.iteritems():
		title = v['title'][len('Institution:'):]
		wtext= v['revisions'][0]['*']
		lat,lon,website=parsePage(wtext)
		if len(lat)>0:  #ignore any pages without coordinates
			txt.append(u'%s|%s|%s|%s\n' %(title,lat,lon,website))
	return apcontinue, txt

def getList(user=None, apcontinue='',filename=u'Institut.dat'):
	'''gets full list of pages in Institution Namespace.
	   Providing a username is optional but recommended as
	   logged-in users may request more results per query.'''
	fout = codecs.open(filename, 'w', 'utf-8')
	opener = urllib2.build_opener(urllib2.HTTPCookieProcessor(CookieJar()))
	apiurl = u'http://commons.wikimedia.org/w/api.php'
	#if user is provided then log in
	if not user is None:
		passw=getpass()
		(token, error) = login(apiurl, user, passw, opener)
	num=0
	lastout=0
	while True:
		apcontinue, plist = getPartList(apiurl, opener, apcontinue)
		num = num+len(plist)
		fout.write(''.join(plist))
		fout.flush()
		if len(apcontinue)==0:
			break
		if num > (lastout+500):
			lastout=lastout+500
			print num
	fout.close()
	print 'Done! Found: %r geotagged institutions' %num

def login(apiurl, user, passw, opener):
    '''logs in user to a wikimedia site and returns an edittoken (or None + error message)'''
    lgname = user
    lgpassword = passw
    error=''
    params = {'action':'login', 'lgname':lgname, 'lgpassword':lgpassword, 'format':'json'}
    req = urllib2.Request(apiurl, data=urllib.urlencode(params))
    response = opener.open(req)
    j = simplejson.loads(response.read())
    if 'error' in j.keys():
        error = j['error']['info']
    else:
        data = j['login']
        if data['result'] == 'NeedToken':
            params['lgtoken'] = data['token']
            req = urllib2.Request(apiurl, data=urllib.urlencode(params))
            response = opener.open(req)
            j = simplejson.loads(response.read())
            if 'error' in j.keys():
                error = j['error']['info']
            else:
                data = j['login']
                if(not data['result'] == 'Success'):
                    error = data['result']
        elif data['result'] == 'Success':
            pass
        else:
            error = data['result']
    if error=='':
        response = opener.open('%s?action=query&prop=info&intoken=edit&titles=Foo&format=json' %apiurl)
        j = simplejson.loads(response.read())
        token = j['query']['pages']['-1']['edittoken']
        return (token,'')
    else:
        return (None, error)
#
