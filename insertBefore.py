#!/usr/bin/python
# -*- coding: utf-8 -*-
import os
import sys
import argparse
#Return if the filename "Entry" is to be considered or not
def test_extension (Entry):
	found=False
	#list of autorised extensions
	autorized_extensions_str=".htm|.html"
	autorized_extensions = autorized_extensions_str.split("|")
	#list of filenames of the good extension but that we don't want to modify
	exception_endofname_str="badfile1.html|badfile2.html"
	exception_endofname = exception_endofname_str.split("|")
	#list of names that we don't want to find in the filename of the files to modifiy
	exception_wordinname_str="name1|name2"
	exception_wordinname = exception_wordinname_str.split("|")
	for ext in autorized_extensions:
		if (Entry.lower().endswith(ext)):
			found=True
	for end in exception_endofname:
		if (Entry.lower().endswith(end)):
			print("refused : %s\n" %Entry)
			found=False
	for word in exception_wordinname:
		if (Entry.lower().endswith(word)):
			print("refused : %s\n" %Entry)
			found=False
	return found

#List all the files that need to be modified and run the modification
def ScanDirectory(Directory,TextControl, TextToSearch, TextToAdd):
	dirs = os.listdir(Directory)
	for Entry in dirs:
		path="%s/%s" %(Directory,Entry)
		if(os.path.isdir(path) and Entry is not '.' and Entry is not '..'):
			ScanDirectory(path,TextControl, TextToSearch, TextToAdd)
		elif (test_extension(Entry)) :
			AddContentBefore(path,TextControl, TextToSearch, TextToAdd)

#Insert the text in the good place in the file, only if necessary
def AddContentBefore (filename,TextControl, TextToSearch, TextToAdd):
	handle = open(filename, "r")
	content = handle.read()
	handle.close()
	n=content.find(TextControl)
	if (n==-1) :
		n=content.find(TextToSearch)
		if (n>=0) :
			handle = open(filename, "w")
			handle.write(content[:n]+ TextToAdd + content[n:])
			handle.close()
			print("%s" %filename)

# main program_______________________________________________
if __name__ == "__main__":
	parser = argparse.ArgumentParser()
	parser.add_argument("SourceFolder", help="source folder's name.")
	parser.add_argument("TextControl", help="is a string that we test the presence in the files, avoiding multiple insertion if the script is called many times")    
	parser.add_argument("TextToSearch", help="is the string before which we want to insert our content")    
	parser.add_argument("TextToAdd", help="is the text to be inserted")    
	#parser.add_argument("AutorizedExtensions", default=".htm|.html", help="is the list of autorized file extensions separated by a '|'. default='.htm|.html'")    
	#parser.add_argument("ExceptionEndofname", default="", help="is the list of end part of filenames that we don't want to modify separated by '|'. default=''")    
	#parser.add_argument("ExceptionWordinname", default="", help="is the list of part of filenames , anywhere in the file name , that we don't want to modify separated by '|'. default=''")

	args = parser.parse_args()
	SourceFolder=args.SourceFolder
	TextControl= args.TextControl
	TextToSearch= args.TextToSearch
	TextToAdd= args.TextToAdd
	ScanDirectory(SourceFolder, TextControl, TextToSearch, TextToAdd)
