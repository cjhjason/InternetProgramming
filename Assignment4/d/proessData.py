def processData(data):
    head, method, request, protocol = ""
    head = (data.decode('utf-8').split("\r\r\n"))[0]
    print ("head: ",head)
    headlist = head.split(" ")
    method, request, protocol = headlist[0], headlist[1], headlist[2]
    print ("method: ",method,"request: ", request,"protocol: ", protocol)

    return head

data_send_back = 'HTTP/1.1 200 OK \r\nDate: Sun, 18 Oct 2009 08:56:53 GMT\r\nServer: Apache/2.2.14 (Win32) \r\nLast-Modified: Sat, 20 Nov 2004 07:16:26 GMT \r\nETag: "10000000565a5-2c-3e94b66c2e680" \r\nAccept-Ranges: bytes \r\nContent-Length: 44 \r\nConnection: close \r\nContent-Type: text/html \r\nX-Pad: avoid browser bug \r\n\r\n <html><body><h1>It works!</h1></body></html>'
# print (data_send_back)

by = bytes(data_send_back, 'utf-8')

def findFile(uri):
    try:
        f = open(uri)
    except Exception as e:
        print ("Error: ",e)
        f = open("404.html")
    finally:
        content = f.read()
        print (content)
        f.close()
    return content

findFile("2.html")
