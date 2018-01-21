import json

graph = {}
graph['nodes'] = []
graph['edges'] = []

f = open('names1000.txt', encoding='utf8')
namesText = f.read()
lines = namesText.split('\n')
for i in range(0, len(lines)):
    currStr = lines[i]
    id = currStr[0:24]
    name = currStr[25:]

    currNode = {}
    currNode['id'] = id
    currNode['caption'] = name
    graph['nodes'].append(currNode)

f = open('related1000.txt', encoding='utf8')
relatedText = f.read()
lines = relatedText.split('\n')
for i in range(0, len(lines)):
    currStr = lines[i].replace('[', '').replace(']', '').replace(',', '').strip()
    neighbors = currStr.split(' ')
    currNode = neighbors[0]
    del neighbors[0]
    for j in range(0, len(neighbors)):
        edge = {}
        edge['source'] = currNode
        edge['target'] = neighbors[j]
        graph['edges'].append(edge)

with open('graph.json', 'w') as outfile:
    json.dump(graph, outfile)