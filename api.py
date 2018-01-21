import requests 
import json
import pprint

#Setup paramaters
key = "AIzaSyDp7y3OsCrUT1sXkCHWqzPAPLnL1i7EqH0"
url = "https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId=UCY30JRSgfhYXA6i6xX1erWg&maxResults=1&key="+key
#url+="&fields=items(id,snippet(channelId,title,categoryId),statistics)&part=snippet,statistics"
response = requests.get(url)
if(response.status_code==200):
    data = response.json()
else: 
    print("failed")
    exit(0)
channel = data['items'][0]['snippet']['channelTitle']
id = data['items'][0]['id']['videoId']
#pprint.pprint(data)
print("channel:",channel)
print("video id:",id)