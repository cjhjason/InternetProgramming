import datetime
import re
import os

OreadPermission = 0o004

# HTTP Status code
http_status_code = {200 : "OK", 301 : "MOVED PERMANENTLY", 400 : "BAD REQUEST", 403 : "FORBIDDEN", 404 : "NOT FOUND", 405 : "METHOD NOT ALLOWED", 406 : "NOT ACCEPTABLE" }


# 1.
# Return true if file exist
def checkFile(uri):
    # No Permission
    try:
        f = open(uri, 'r')
    except Exception as e:
        # print ("CHECKFILE ERROR: ",e)
        return False
    else:
        if  os.stat(uri).st_mode & OreadPermission == 0:
            return False
        f.close()
        return True

# following function 1, determine 403 or 404
# success return 0, PermissionError return 403, FileNotFoundError return 404
def checkFile_403OR404(uri):
    try:
        f = open(uri, 'r')
    # 403
    except PermissionError:
        return 403
    # 404
    # GET FORM
    except FileNotFoundError:
        return 404
    except Exception as e:
        # print ("CHECKFILE ERROR: ",e)
        return -1
    else:
        if  os.stat(uri).st_mode & OreadPermission == 0:
            return 403
        f.close()
        return 0

# 2.
def checkMethod(method):
    if method == "GET":
        return True
    elif method == "HEAD":
        return True
    elif method == "POST":
        return True
    else:
        # print ("Method not Supported")
        return False

# 3.
def checkProtocal(protocal):
    if protocal == "HTTP/1.1" or protocal == "HTTP/1.0":
        # print ("CHECKED PROTOCAL: HTTP/1.1 OR HTTP/1.0")
        return True
    else:
        print ("CHECKED PROTOCAL: NOT HTTP/1.1 OR HTTP/1.0")
        print ("UNSUPPORT PROTOCALL: ",protocal)
        return False


# read file and return content
# check 403 and 404
def readFile(uri):
    content = ""
    try:
        f = open(uri, 'r')
    except Exception as e:
        print ("Error: ",e)
        return ""
    else:
        content = f.read()
        f.close()
    finally:
        return content


# protocol -> type string; status code -> type int; accept -> type string

def getResponse(protocol, uri, code, accept, head):

    # init
    response = ""
    responseHead = ""

    # 403 404
    if (checkFile_403OR404(uri) == 403):
        code = 403
    elif (checkFile_403OR404(uri) == 404):
        code = 404
    # 301
    if uri == "csumn":
        code = 301

    # Never happen, if, something goes wrong
    if code == -1:
        print ("NEVER GOES HERE, GETRESPONSE")
        return ""

    # 406
    file_extension = os.path.splitext(uri)[1].strip(".")
    # print ("file_extension:", file_extension)
    # print ("accept:",accept)
    # print (protocol, uri, code, accept, head)

    # can't recognize img/* True -> TYPE NOT CORRECT ! -> TRIGGER 406
    # WHEN accpet is not specify, it is default to accept everything
    AcceptType = True
    if file_extension in accept:
        AcceptType = False
    if "*/*" in accept:
        AcceptType = False
    if accept == "":
        AcceptType = False

    if AcceptType:
        # print ("Status code: 406")
        code = 406
        responseHead = protocol + " " + str(code)  + " " + http_status_code[code] + "\r\n"
    else:
        # first line
        responseHead = protocol + " " + str(code)  + " " + http_status_code[code] + "\r\n"
    if (head == False):
        # content-length fill up late
        # date:
        response += "date: "
        response += datetime.datetime.utcnow().strftime('%a, %d %b %y %H:%M:%S GMT')
        response += "\r\n"
        # server
        response += "server: myServer \r\n"
        # accept, only send text/html now
        response += "content-type: "
        response += "text/html; charset=UTF-8 \r\n"
        # response += "Content-Security-Policy: upgrade-insecure-requests \r\n"
        if code != 200 and code != 301:
            response += "Connection: close\r\n"
        if code == 405:
            response += "Allow: GET, HEAD \r\n"
        if code == 301:
            response += "Location:  https://www.cs.umn.edu/ \r\n"


        # end with extra one line
        response += "\r\n\r\n"
        contentLength = 0
        # attach file
        if code == 200:
            response += readFile(uri)
            contentLength = len(readFile(uri))
        elif code == 400:
            response += readFile("400.html")
            contentLength = len(readFile("400.html"))
        elif code == 403:
            response += readFile("403.html")
            contentLength = len(readFile("403.html"))
        elif code == 404:
            response += readFile("404.html")
            contentLength = len(readFile("404.html"))
        elif code == 301:
            pass
        else:
            response += readFile("400.html")
            contentLength = len(readFile("400.html"))

        if code != 200 and code != 301:
            response = "content-length: " + str(contentLength) + "\r\n" + response
        response = responseHead + response

    else:
        response = responseHead

    # CRLF = '\r\n'
    # OK = 'HTTP/1.1 200 OK{}{}{}'.format(CRLF,CRLF,CRLF)
    # response = OK + readFile(uri)

    return response

def getPostResponse(protocol, r):
    response = protocol + " " + str(200)  + " " + http_status_code[200] + "\r\n\r\n\r\n"
    response += "<html>\n<body>\n<h2> Following Form Data Submitted Successfully </h2>\n"
    infoList = r.split("&")
    infoName = ["Event Name:","StartTime:","End Time:","Location:","Day of the Week:"]
    dataList = []
    for i in range(0,len(infoList)):
        dataList.append(infoList[i].replace("%3A",":").split("="))
    for i in range(0,len(infoName)):
        response += "   <p>" + infoName[i] + dataList[i][1] + "</p>" + "\n"
    response += "</body>\n</html>\n"
    return response

def processData(data):
    # init
    response = ""
    head = ""
    method = ""
    uri = ""
    protocol= ""
    accept = ""

    # decode data
    data = data.decode('utf-8')

    if not data:
        return ""

    # slice first line out (HEAD) (MODIFY: NOT NEEDED ANY MORE)
    head = (data.split("\r\n"))[0]
    # head = (data.split("\n"))[0]
    headlist = head.split(" ")

    # EZ METHOD
    splitData = data.split()

    # store needed data (method, url, protocol)
    # method, uri, protocol = headlist[0], headlist[1], headlist[2]

    # EZ METHOD to -> store needed data (method, url, protocol)
    method, uri, protocol = splitData[0], splitData[1], splitData[2]
    # dealing with open("/xxx") fail
    if uri[0] == "/":
        uri = uri[1:]
    # remove all spaces
    method = ''.join(method.split())
    uri = ''.join(uri.split())
    protocol = ''.join(protocol.split())

    # match Accept from data (Accept: )
    pattern = "Accept:.+"
    result = re.search(pattern, data) # Match
    if (result):
        accept = result.group()[7:]


    # DEBUG
    # print ("DEBUG")
    # print ("head: ",head)
    # print ("method:",method,"uri:", uri,"protocol:", protocol)
    # print ("Accept: ", accept)
    # print ("\n")
    # print (uri)
    # print ("DEBUG",checkMethod(method))
    # print ("DEBUG", checkFile(uri))
    # print ("DEBUG",checkProtocal(protocol))
    # -------------------------------------------------------------


    # 200 OK and 406 is checked inside function getResponse
    if (checkMethod(method) and checkFile(uri) and checkProtocal(protocol)):
        if method == "GET":
            response = getResponse(protocol, uri, 200, accept, False)
        elif method == "HEAD":
            response = getResponse(protocol, uri, 200, accept, True)
        elif method == "POST":
            # TODO POST
            print ("POST")
        else:
            print ("SHOULD NOT GET HERE")



    # 405 Method Not Allowed
    elif (not checkMethod(method) and checkFile(uri) and checkProtocal(protocol)):
        response = getResponse(protocol, uri, 405, accept, False)

    # 403 and 404 file PermissionError and FileNotFoundError
    # 301
    elif (checkMethod(method) and not checkFile(uri) and checkProtocal(protocol)):
        if method == "GET":
            response = getResponse(protocol, uri, -1, accept, False)
        elif method == "HEAD":
            response = getResponse(protocol, uri, -1, accept, True)
        elif method == "POST":
            # TODO POST
            # last line contain data submited
            r = splitData[-1]
            response = getPostResponse(protocol, r)
        else:
            print ("SHOULD NOT GET HERE")

    # All the other error code
    else:
        if method == "GET":
            response = getResponse(protocol, uri, 400, accept, False)
        elif method == "HEAD":
            response = getResponse(protocol, uri, 400, accept, True)
        elif method == "POST":
            # TODO POST
            print ("POST")
        else:
            print ("SHOULD NOT GET HERE")


    # add 512 space let chrome display the page
    print ("DATA SEND BACK", "Length:", len(response))
    print (response)
    return response



# main
if __name__ == '__main__':
    # DEBUG 1.getResponse("HTTP/1.1", 200 "text/html; charset=UTF-8")
    # print (getResponse("HTTP/1.1", 200, "/.html",  "text/html; charset=UTF-8"))
    # -------------------------------------------------------------------
    # DEBUG 2. re.match
    # pattern = "Accept:.+"
    # s = "Accept:image/webp,image/apng,image/*,*/*;q=0.8 \n "
    # # s = " "
    # # result = re.search(pattern, s)
    # result = re.match(pattern, s) # Match
    # if (result):
    #     print (result.group()[7:])
    # DEBUG 3
    # print (readFile("somefile"))
    # DEBUG 4 406
    # s = "image/webp,image/apng,image/*,*/*;q=0.8 \n "
    # s1 = "text/html; charset=UTF-8"
    # s2 = "/calendar.html"
    # s3 = "/some.jpg"
    # s4 = "/some.png"
    # file_extension = os.path.splitext(s2)[1].strip(".")
    # print (file_extension)
    # if file_extension in s1:
    #     print ("html")
    # if (result):
    #     print (result.group())
    # DEBUG
    f = open("request")
    data = f.read().encode("utf-8")
    # print (data)
    print (processData(data))





    # print (checkFile("index.html"))

    # -------------------------------------------------------------------
