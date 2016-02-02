## == 3 not acceptable

import copy
import xlrd
from xlrd import open_workbook,empty_cell
import xlwt
import random
import collections
from random import randrange
import sys

####GLOBAL VARIABLES####
Days = ['M', 'T', 'W', 'R', 'F']

inputs = raw_input('\nPlease specify the name of the file you wish to have analyzed (Must be in the same directory as the program): ')

output = xlwt.Workbook()
book = xlrd.open_workbook(inputs)

sheet_teacher = book.sheet_by_index(0)
sheet_classes = book.sheet_by_index(1)

It = collections.Iterable

def flatten(L):
    for e in L:
        if isinstance(e, It) and not isinstance(e, basestring):
            for sub in flatten(e):
                yield sub
        else:
            yield e

#num_classes_taught = []
teachers = {}   #Temporary dictionary creating the keys and attached lists
classes = {}    #Dict linking the class names to CRNs
rankings = {}  #Dictionary for teachers rankings
numbers = {} #Dictionary linking teachers' name to the # classes they need to teach
sections = {} #Dictionary of dictionaries, technically, linking class names to lectures to sections. ie: 17A -> 17A-a -> 17A-a-01

classstimes = {} # temp time dictionary used for writing times to output
classtimes = {} # TEMP Dictionary linking CRNs with times
class_times = {} #Dictionary linking CRNs with times
classrank = {} # dictionary of crns to rank entry for adding dummy tas to blacklist of advanced classes
TA_conflicts = {} # TEMP Dictionary linking TAs with CRNs they cannot teach
TAconflicts = {} # REAL Dictionary linking TAs with CRNs they cannot teach

#Temporary dicts for constructing the preference dictionary
teachers_like = {}
teachers_hate = {}
teachers_indif = {}

#The final preference dictionary used in the algorithm
blacklist = {}  #The blacklist dictionary
teachers_pref = {}

#The final preference dictionary used in the algorithm
class_pref = {}

#####################################################################
########CHECKS INPUT TO SEE IF EVERYTHING IS FINE####################
#####################################################################
units  = 1
while units < (sheet_teacher.nrows):
    if isinstance(sheet_teacher.cell(units, 4).value, float) and sheet_teacher.cell(units,4).value % 1 == 0:
        if isinstance(sheet_teacher.cell(units, 5).value, float) and sheet_teacher.cell(units,5).value % 1 == 0:
            units+=1
        else:
            print "\nYou may have entered a non-integer in the 'Ranking' column on the first sheet, line",str(units+1)+". Please edit your excel file accordingly!"
            sys.exit("PLEASE EDIT YOUR EXCEL FILE!")
    else:
        print "You may have entered a non-integer in the fifth column on the first sheet, line",str(units+1)+". Please edit your excel file accordingly!"
        sys.exit("PLEASE EDIT YOUR EXCEL FILE!")

units = 1
while units < (sheet_classes.nrows):
    if isinstance(sheet_classes.cell(units, 0).value, float) and sheet_classes.cell(units,0).value % 1 == 0:
        if isinstance(sheet_classes.cell(units,3).value, float) and sheet_classes.cell(units,3).value % 1 == 0:
            units+=1
        else:
            print "You may have entered a non-integer in the 'Rankings' column on the second sheet, line",str(units+1)+". Please edit your excel file accordingly!"
            sys.exit("PLEASE EDIT YOUR EXCEL FILE!")
    else:
        print "You may have entered a non-integer in the 'CRNs' column on the second sheet, line",str(units+1)+". Please edit your excel file accordingly!"
        sys.exit("PLEASE EDIT YOUR EXCEL FILE!")

#Gets the total number of classes needing to be taught
units = 1
class_num = 0
while units < (sheet_teacher.nrows):
    class_num += int(sheet_teacher.cell(units, 4).value)
    units+=1    

dummy_classes = []
dummy_TA = []

TA_shortage = 0
class_shortage = 0
if (sheet_classes.nrows - 1) < class_num:
    class_shortage = class_num - (sheet_classes.nrows - 1)
    for num in range(class_shortage):
        dummy_classes.append(unicode('NO CLASS ' + str(num + 1)))
#   print "Error: there are not enough teachers to teach all of #these classes.\n"

elif (sheet_classes.nrows - 1) > class_num:
    TA_shortage = (sheet_classes.nrows - 1) - class_num
    for num in range(TA_shortage):
        dummy_TA.append(unicode('NO TEACHER ' + str(num + 1)))


###########Should be added to the HTML on website#########

##At the end, print out the number of classes that do not have TAs
#####Instead of implementing this step. 
######If there are not enough TAs, then have the Engineering Student teacher the lowest classes

#Read in TA conflicts and class times
i = 1
while i < sheet_teacher.nrows:
    if sheet_teacher.cell(i,  3).ctype is not empty_cell:
        TA_conflicts[sheet_teacher.cell(i, 0).value] = sheet_teacher.cell(i, 3).value
        i += 1
    else:
        #del ta_conflicts[sheet_teacher.cell(i, 0).value] 
        i += 1

#######################
#######################
##Reads in the sections dictionary, so we can use names in place of CRNs
##First generates a list of class section names that we will parse through
j = 1
class_names = []
while j < sheet_classes.nrows:
	k = sheet_classes.cell(j, 1).value
	if isinstance(k, (int, long, float, complex)):
		k = unicode(int(k))
	else:
		k = unicode(k)
	class_names.append(k)
	j+=1

#Then generates the keys of the outter-most dictionary
for i in range(len(class_names)):
	temp = class_names[i].split('-')
	sections[temp[0]] = {}

##Then generates the keys of the inner dictionary
for i in range(len(class_names)):
	temp = class_names[i].split('-')
	if len(temp) == 3:
		sections[temp[0]][temp[0]+'-'+temp[1]] = []

##Assigns the individual sections to the separate lectures
for i in range(len(class_names)):
	temp = class_names[i].split('-')
	if len(temp) == 3:
		sections[temp[0]][temp[0]+'-'+temp[1]].append(class_names[i])
#############################
#############################
#############################		


##Reads in the class times, this links section names to times
j = 1
while j < sheet_classes.nrows:
	k = sheet_classes.cell(j, 1).value
	if isinstance(k, (int, long, float, complex)):
		k = unicode(int(k))
	classstimes[k] = sheet_classes.cell(j, 2).value
	j += 1

#Then parses the class times into a list, blah blah
#Then parses the class times into a list
for class_name in classstimes:
	times = classstimes[class_name].split(",")
	for name in times:
		j = times.index(name)
		if name[0] == ' ':
			times[j] = name[1:]
	classtimes[class_name] = times

##Read in class ranking using section name as key
j = 1
while j < sheet_classes.nrows:
	k = sheet_classes.cell(j, 1).value
	if isinstance(k, (int, long, float, complex)):
		k = unicode(int(k))
	classrank[k] = unicode(int(sheet_classes.cell(j, 3).value))
	j += 1


##This creates the dictionary we use to create the TAs preferences dictionary later, it also appends in the fake TAs that we made earlier
teacher_name = 1
while teacher_name < (sheet_teacher.nrows + TA_shortage + 1):
    if teacher_name < sheet_teacher.nrows:
        teachers[sheet_teacher.cell(teacher_name, 0).value] = []
    elif TA_shortage != 0:
        if teacher_name > sheet_teacher.nrows - 1:
            teachers[dummy_TA[(teacher_name - sheet_teacher.nrows) - 1]] = [] 
    teacher_name+=1


##Makes the skeleton of the class preference dictionary
class_name = 1
while class_name < (sheet_classes.nrows + class_shortage + 1):
    if class_name < sheet_classes.nrows:
        j = sheet_classes.cell(class_name, 1).value
        if isinstance(j, (int, long, float, complex)):
            j = unicode(int(j))
        if j not in classes:
            classes[j] = []
    elif class_shortage != 0:
        if class_name > sheet_classes.nrows:
            classes[dummy_classes[(class_name - sheet_classes.nrows) - 1]] = []
    class_name+=1


########################
#Generates a dictionary of # of classes to TAs    
units = 1
while units < (sheet_teacher.nrows):
    numbers[sheet_teacher.cell(units, 0).value] = unicode(int(sheet_teacher.cell(units,4).value))
    units+=1
if TA_shortage != 0:
    for dummy in dummy_TA:
        numbers[dummy] = unicode(1)


####################################################
###THIS IS WHERE THE CLASS_TIMES DICTIONARY STARTS##
####################################################
#######STEP 1: SPLIT UP INPUT DICTIONARY

for classs in classtimes:
    i = 0
    time = classtimes[classs]
    for item in time:
        sorted_list = item.split(" ")
        time[i] = sorted_list
        i = i+1
    j = 0
    for items in time:
        for string in time[j]:
            if string.isalpha():
                time[j][time[j].index(string)] = list(string)
        j += 1
    k = len(time)

########STEP 2: MAKE A DICTIONARY
    i = 0
    class_times[classs] = []

    while i<k:
        for day in time[i][0]:
            for listed_time in time[i]:
                class_times[classs].append([day,listed_time])
        i = i + 1
    for tupleton in class_times[classs]:
        if tupleton[1][0] in Days:
            class_times[classs].remove(tupleton)

#######STEP 3: MAKE DICTIONARY BETTTERRRRRRRRRRRRRRRRRRRRRRR!!!!!!!!!!!!!!!!!!
    length = len(class_times[classs])
    for x in range(length):
        if isinstance(class_times[classs][x][1], list) == 1:
            break
        else:
            startend = class_times[classs][x][1].split('-')
            n =  float(startend[1]) - float(startend[0])
            i = 0
            while i < 2*n:
                class_times[classs].append([class_times[classs][x][0], str(float(startend[0]) + (i*0.5))])
                i += 1
    j = 0
    l = 1
    while j is 0:
        if l is length + 1:
            break
        else:
            class_times[classs].pop(0)
            l += 1 

####################################################
###This is where the time conflicts code starts#####
####################################################
blacktime = {}

# Create black_time dictionary
for crn in class_times:
    blacktime[crn] = []

#print class_times
    
for TA in TA_conflicts:
    conflicts = TA_conflicts[TA] # edit: changing variable name "random" to "conflicts" (ambiguity with random function)
    randoms = conflicts.split(", ") # unnecessary step due to lack of punctuation requirements
    i = 0
###########STEP 1: split up input string so we can parse through it and make into dictionary
    for randomss in randoms:
        sorted_list = randomss.split(" ")
        randoms[i] = sorted_list
        i = i+1 # splitting by spaces
    j = 0
    for item in randoms:
            for string in randoms[j]:
                    if string.isalpha():
                            randoms[j][randoms[j].index(string)] = list(string)
            j += 1 #making a sublist for strings that are entirely alphabetical
    k = len(randoms)
############STEP 2: Create a dictionary using the split up string
    i = 0
    TAconflicts[TA] = []

    while i < k:# make sure you don't go outside range of list (length k)
        for day in randoms[i][0]:# randoms[0][0] = ['M', 'W', 'F'], randoms[1][0] = ['T', 'R']
            for time in randoms[i]: # random[i] is a list of days
                TAconflicts[TA].append([day,time]) # add a list of lists to current TA
        i = i + 1 # iterate i by 1 (next list of days)
            
    for tupleton in TAconflicts[TA]: # removes all entries where the second element is a list of days
        if tupleton[1] == u'' or tupleton[1][0] in Days: # if first entry in list has a day entry...
            TAconflicts[TA].remove(tupleton) # remove that tupleton from the list of time conflicts

############STEP 3: Compare TAconflicts dictionary with the dictionary of CRNs to times
    #if conflict overlaps time of class
        #add TA to blacktime of class

    #take conflicts dict and split tuples into 1/2 hr intervals
    length = len(TAconflicts[TA]) # number of original elements in the list of lists
    for time in range(length): # for loop breaking time into half hour segments
        if isinstance(TAconflicts[TA][time][1], list) == 1:
            break
        else:
            startend = TAconflicts[TA][time][1].split('-') # split time ranges ex. '9-12' -> ['9', '12']
            k = float(startend[1]) - float(startend[0]) # Difference between times (range) ex. 12 - 9 = 3
            i = 0
            while i < 2*k: # Want to break up each hour into half hour increments 
                TAconflicts[TA].append([TAconflicts[TA][time][0], str(float(startend[0]) + (i*0.5))]) 
                i += 1
    j = 0               
    l = 1
    while j is 0: # j will always be 0, test to make sure we don't go oustide the range of the list
        if l is length + 1:
                break
        else:
                TAconflicts[TA].pop(0) # removes old entries in list (entries before breaking)
                l += 1
    
    #take class times dict and split tuples into 1/2 hr intervals
    for crn in class_times: 
            if isinstance(class_times[crn][1], list) == 1:
                break
            else:
                startend = class_times[crn][1].split('-') # split time ranges ['start', 'end']
                k = float(startend[1]) - float(startend[0]) # difference between times i.e. end - start
                original = class_times[crn] 
                i = 0
                while i < 2*k:
                    class_times[crn].append([original[0], str(float(startend[0]) + (i*0.5))])
                    i += 1
                del class_times[crn][0] # first deletion, does not maintain proper indexing
                del class_times[crn][0] # second deletion necessary to maintain proper indexing
    
    # Loop through TAs and compare it to the class_times dictionary.  If match, add to black list

    for time in TAconflicts[TA]: # iterate through time conflicts for particular TA
        for crn in class_times: # iterate through CRNs
          #  print crn
           # print class_times[crn]
            if time in class_times[crn]: # check if TA time conflict agrees with class time
                if TA in blacktime[crn]: # check if TA name is already there, if it is
                    break # Don't add another duplicate of the TA name
                blacktime[crn].append(TA) # add TA name to CRN of class they cannot teach


#####
#####
##This generates the skeleton of the blacklist using section names
black = 1
while black < sheet_classes.nrows:
    j = sheet_classes.cell(black, 1).value
    if isinstance(j, (int, long, float, complex)):
            j = unicode(int(j))
    if j not in blacklist:
        blacklist[j] = []
    black+=1


##This reads in 
for black in range(1, sheet_classes.nrows):
    if sheet_classes.cell(black, 4).ctype is not empty_cell:
        j = sheet_classes.cell(black, 1).value
        if isinstance(j, (int, long, float, complex)):
            j = unicode(int(j))         
        blacklist[j].append(sheet_classes.cell(black, 4).value)
        blacklist[j] = (sheet_classes.cell(black, 4).value).split(', ')
    if classrank[j] == unicode(1):
        blacklist[j].extend(dummy_TA)
    black+=1

#Removes those empty strings from our blacklist. 
black = sorted(blacklist.keys())
for item in black:
    while '' in blacklist[item]:
        blacklist[item].remove('')
 
blackL = sorted(blacklist.keys())
blackT = sorted(blacktime.keys())   

for item in blackL:  # Loops throught the blacklist keys
    for thing in blackT:  # Loops through the blacktime keyes
        if item == thing:  # Checks to see if the keys are the same, if they are:
            for element in blacktime[thing]:  # Loops through the corresponding list for the crn key 
                if element not in blacklist[item]:  #If the name isn't in the blacklist, it adds it
                    blacklist[item].append(element)

## Loops through the blacklist and if there is a TA who is not on the TA sheet,
# it removes him from the blacklist

teachers_list = sorted(teachers.keys())

for item in black:
    if blacklist[item]:
        temp_list = []
        for name in range(len(blacklist[item])):
            if blacklist[item][name] not in teachers_list:
                print '\n' + blacklist[item][name],'is not listed as a teacher or TA. He or she was listed as part of the blacklist for',item+'.'
                print "Please edit your excel file accordingly. Thank you."
                sys.exit("IGNORE THIS ERROR. The program ran fine.")


##Adds duplicates to the blacklist
for item in black:
    j = black.index(item)
    if blacklist[item]:
        for name in blacklist[item]:
            i = blacklist[item].index(name)
            # print blacklist[item][i]
            if int(numbers[name]) > 1:
                num_classes = 1
                more = []           
                more.append(blacklist[item][i] + ' ' + str(1))
                # print (num_classes +1), "<", numbers[name]
                while num_classes < int(numbers[name]):
                    blacklist[item][i] 
                    more.append(blacklist[item][i] + ' ' + str(num_classes + 1))
                    num_classes+=1
                blacklist[item][i] = more
                blacklist[item] = list(flatten(blacklist[item]))

                
#############################3
##
crn = 1
while crn < sheet_classes.nrows + class_shortage + 1:
    if crn < sheet_classes.nrows:    
        j = sheet_classes.cell(crn, 1).value
        if isinstance(j, (int, long, float, complex)):
            j = unicode(int(j))
        i = sheet_classes.cell(crn, 0).value
        if isinstance(i, (int, long, float, complex)):
            i = unicode(int(i)) 
        classes[j] = i

    elif class_shortage != 0:
        if crn > (sheet_classes.nrows + class_shortage - 1):
            classes[unicode('NO CLASS ' + str(crn - sheet_classes.nrows))] = []    
    crn+=1

for dummy in dummy_classes:
	classes[dummy].append(unicode(random.randint(1000000000, 9999999999)))

teachers_like = copy.deepcopy(teachers)
teachers_hate = copy.deepcopy(teachers)
teachers_indif = copy.deepcopy(teachers)

##
classs = copy.deepcopy(class_names)

classs.extend(dummy_classes)
class_names.extend(dummy_classes)

like = 1
while like < sheet_teacher.nrows:
    if sheet_teacher.cell(like, 1).ctype is not empty_cell:
        temp_list = []
        i = unicode(str(sheet_teacher.cell(like, 1).value))
        j = unicode(str(sheet_teacher.cell(like, 0).value))
        teachers_like[j].append(i)
        teachers_like[j] = (i).split(', ')
#    for item in teachers_like[j]:
 #       if item not in classs:
  #          temp_list.append(item)
#    for element in temp_list:
 #       teachers_like[j].remove(element)
    like+=1


##
teacher = sorted(teachers_like.keys())
temp = {}

temp = copy.deepcopy(teachers)
  
###Randomize the likes, do this laterrrr!!

for one in teacher:
	for item in teachers_like[one]:
		j = item.split('-')
		if j[0] not in sections.keys():
			teachers_like[one].remove(item)
			break
		elif len(j) == 1:
			item = sections[j[0]]
			#print "item",item
			keys = sorted(item.keys())
			for each in keys:
				temp[one].extend(item[each])
				teachers_like[one].extend(temp[one])
				temp[one] = []
		if len(j) == 2:
			k = j[0]+"-"+j[1]
			if k not in sections[j[0]]:
				teachers_like[one].remove(item)
				break
			else:
				item = sections[j[0]][k]
				temp[one].extend(item)
				teachers_like[one].extend(temp[one])
		if len(j) > 2:
			m = j[0]+"-"+j[1]
			k = j[0]+"-"+j[1]+"-"+j[2]
			if k not in sections[j[0]][m]:
				teachers_like[one].remove(item)

for one in teacher:	
	temp = []
	for item in teachers_like[one]:
		if item not in class_names:
			temp.append(item)	

	for item in temp:
		teachers_like[one].remove(item)


##
hate = 1
while hate < sheet_teacher.nrows:
    if sheet_teacher.cell(hate, 2).ctype is not empty_cell:
        temp_list = []
        j = unicode(str(sheet_teacher.cell(hate, 0).value))
        i = unicode(str(sheet_teacher.cell(hate, 2).value))
        teachers_hate[j].append(i)
        teachers_hate[j] = (i).split(', ')
#    for item in teachers_hate[j]:
 #       if item not in classs:
  #          temp_list.append(item)
   # for element in temp_list:
    #    teachers_hate[j].remove(element)
    hate+=1

##
teacher = sorted(teachers_like.keys())
temp = {}

temp = copy.deepcopy(teachers)
  
###Randomize the likes, do this laterrrr!!

for one in teacher:
	for item in teachers_hate[one]:
		j = item.split('-')
		if j[0] not in sections.keys():
			teachers_hate[one].remove(item)
			break
		elif len(j) == 1:
			item = sections[j[0]]
			#print "item",item
			keys = sorted(item.keys())
			for each in keys:
				temp[one].extend(item[each])
				teachers_hate[one].extend(temp[one])
				temp[one] = []
		if len(j) == 2:
			k = j[0]+"-"+j[1]
			if k not in sections[j[0]]:
				teachers_hate[one].remove(item)
				break
			else:
				item = sections[j[0]][k]
				temp[one].extend(item)
				teachers_hate[one].extend(temp[one])
		if len(j) > 2:
			m = j[0]+"-"+j[1]
			k = j[0]+"-"+j[1]+"-"+j[2]
			if k not in sections[j[0]][m]:
				teachers_hate[one].remove(item)

for one in teacher:	
	temp = []
	for item in teachers_hate[one]:
		if item not in class_names:
			temp.append(item)	

	for item in temp:
		teachers_hate[one].remove(item)


for ta in teachers_hate:
    teachers_hate[ta].reverse()

for ta in teachers_hate:
    teachers_hate[ta].extend(dummy_classes)

##
indifs = sorted(teachers_indif.keys())


for name in indifs:
    for klass in class_names:
        if((klass not in teachers_like[name]) and (klass not in teachers_hate[name])):
            teachers_indif[name].append(klass)


##Combines teachers prefs into one dict
teachers_pref = {}


###################################
######################################
####Technically, this is what we need for the extended algorithm, but 
####the below function is adequate for monday, because it allows us to 
####use the generic algorithm, in place of the extended algorithm
####################################################################
##################################################
#for name in indifs:
#   teachers_pref[name] = []
#   teachers_pref[name].append(teachers_like[name])
#   teachers_pref[name].append(teachers_indif[name])
#   teachers_pref[name].append(teachers_hate[name])
##################gcchwalik@ElectroTech:~/LP/GS$ python test2.py < teach##
#print "Before ", teachers_pref
#print "Teachers indiff ", teachers_indif
#print "Classes ", classes
for name in indifs:
    teachers_pref[name] = []
    teachers_pref[name].extend(teachers_like[name])
    #randomizes the indifs:
    teach = len(teachers_indif[name])
    lyst = random.sample(teachers_indif[name][:teach], teach)
    teachers_pref[name].extend(teachers_indif[name])   
    teachers_pref[name].extend(teachers_hate[name])
    while '' in teachers_pref[name]:
        teachers_pref[name].remove('')



##Reads in the teachers' rankings
rank = 1
while rank < sheet_teacher.nrows:
    i = sheet_teacher.cell(rank, 5).value
    rankings[unicode(int(i))] = []
    rank+=1

rank = 1
for rank in range(1, sheet_teacher.nrows):
	i = sheet_teacher.cell(rank, 5).value #the ranking
	j = sheet_teacher.cell(rank, 0).value #the name
#    k = int(sheet_teacher.cell(rank, 4).value) #the number of classes teaching
 #   if k > 1:
  #      num_classes = 1
   #     rankings[unicode(int(i))].append(j + ' ' + str(num_classes))
   #     while num_classes < k:
    #        rankings[unicode(int(i))].append(j + ' ' + str(num_classes+1))  
  #          num_classes+=1
    #   print rankings
    #   print "\n\n"
        #rankings[unicode(int(i))].remove(j)    
 #   else:	
	rankings[unicode(int(i))].append(j)
  #  rank+=1


#print "After ", teachers_pref
##This generates the preference dictionaries for the crns
##
for klass in class_names:
	class_pref[klass] = []

##
rank = sorted(rankings.keys())
for klass in class_names:
	for item in rank:
		teach = len(rankings[item])
		class_pref[klass].extend(random.sample(rankings[item][:teach], teach))


##Now add the duplicates to the class_pref list
for klass in class_names:
	for item in class_pref[klass]:
		j = class_pref[klass].index(item)
		temp = []
		if int(numbers[item]) > 1:
			num_classes = 1
		#	print class_pref[klass]
			temp.append(item + ' ' + str(num_classes))
			while num_classes < int(numbers[item]):
				temp.append(item + ' ' + str(num_classes+1))  
				num_classes+=1   
			class_pref[klass][j] = temp
	class_pref[klass] = list(flatten(class_pref[klass])) 
	
#print class_pref

for crn in class_pref:
    class_pref[crn].extend(dummy_TA)


##Adds duplicates to prefs dict according to number of classes to be taught
for name in range(1, sheet_teacher.nrows):
    k = int(sheet_teacher.cell(name, 4).value)
    if k > 1:
        num_classes = 1
        while num_classes < k:
                teachers_pref[(sheet_teacher.cell(name, 0).value) + ' ' + str(num_classes + 1)] = copy.copy(teachers_pref[sheet_teacher.cell(name, 0).value])
                teachers_pref[(sheet_teacher.cell(name, 0).value) + ' ' + str(num_classes)] = copy.copy(teachers_pref[sheet_teacher.cell(name, 0).value])
                num_classes+=1
        del teachers_pref[(sheet_teacher.cell(name, 0).value)]      

## Removes from the preference lists any classes that aren't actually being taught that quarter.  This simplifies it for the sake of run-time

#print teachers_pref
#teacher_keys = sorted(teachers_pref.keys())
#print teacher_keys

#for teach in teacher_keys:
#   print teach
#   print teachers_pref[teach]
#   for index,item in enumerate(teachers_pref[teach]):
#       print index,item
#       if item not in classes.keys():
#           teachers_pref[teach].remove(item)
#print teachers_pref


## This goes with the below function. It's necessary to make the list
teacher_keys = sorted(teachers_pref.keys())

###########################
## Generates the dictionary of preferences for the Tas, it randomizes them for the sake of this version. That way each class doesn't have the exact same preference for the TAs as they are read in.  This is because this version doesn't have preferences for the TAs listed.
###########################
#for klass in classs:
#    teach = len(teacher_keys)
#    lyst = random.sample(teacher_keys[:teach], teach)
#    for crn in classes[klass]:
#        class_pref[crn] = lyst
    

##This is where we're going to plug in the randomized crns for the actual classnames, so that the algorithm will run.

#for teacher in teacher_keys: #sorts through the tas individually
 #   for item in teachers_pref[teacher]: #sorts through each item in their preference list
  #      j = teachers_pref[teacher].index(item)
    #randomizes the corresponding crns:
   #     teach = len(classes[item])
    #    lyst = random.sample(classes[item][:teach], teach)
##Then assigns that randomized list of crns to the ta's preferred class order
     #   teachers_pref[teacher][j] = lyst
      #  teachers_pref[teacher] = list(flatten(teachers_pref[teacher]))


#print "class\n",class_pref
#print "TAs\n",teachers_pref    

#print blacklist

##After creating the preference dictionaries, but before making the copies, let's remove the blacklisted names.
#We made the blacklisted dictionary up about, it's here that we remove the class names from the TAs lists, because it's easier before we plug in the crns.
##


black = sorted(blacklist.keys())
teacher_keys = sorted(teachers_pref.keys())
for person in teacher_keys: #loops through all the teachers
    for item in black:  #loops through the keys of the blacklist
        for each in blacklist[item]:  #loops through the corresponding values
            if person == each:  
                #print teachers_pref[person]
               # print item
                teachers_pref[person].remove(item)

########    
##Then we remove the tas from the crns list if they're blacklisted
########

black = sorted(blacklist.keys())
classs = sorted(classes.keys())
for item in black:
    j = black.index(item)
    if blacklist[item]:
        for name in blacklist[item]:
            class_pref[item].remove(name)

#print "class changed\n",class_pref
#print "TAs changed\n",teachers_pref

#######TA Optimal#######

guyprefers = teachers_pref
galprefers = class_pref

#this sorts the members of each sex alphabetically, I'm not fully certain why this is necessary
guys = sorted(guyprefers.keys())
gals = sorted(galprefers.keys())
 
guysfree = guys[:]
 
#this is another function that plays matchmaker
def matchmaker():
    engaged  = {}
    guyprefers2 = copy.deepcopy(guyprefers)
    galprefers2 = copy.deepcopy(galprefers)
    while guysfree:
        guy = guysfree.pop(0)
        guyslist = guyprefers2[guy]
        gal = guyslist.pop(0)
        fiance = engaged.get(gal)
        if not fiance:
            # She's free
            engaged[gal] = guy
            #print("  %s and %s" % (guy, gal))
        else:
            # The bounder proposes to an engaged lass!
            galslist = galprefers2[gal]
            if guy in galslist:
                if galslist.index(fiance) > galslist.index(guy):
                    # She prefers new guy
                    engaged[gal] = guy
                    #print("  %s dumped %s for %s" % (gal, fiance, guy))
                    if guyprefers2[fiance]:
                        # Ex has more girls to try
                        guysfree.append(fiance)
                else:
                    # She is faithful to old fiance
                    if guyslist:
                        # Look again
                        guysfree.append(guy)
    return engaged

#this is where the program actually starts to run
#print('\nEngagements:')
engaged = matchmaker()
for guy in guys:
    if guy not in engaged.values() and guy not in dummy_TA:
        guysfree.append(guy)
galsfree = []

for gal in gals:
    if gal not in engaged.keys():
        galsfree.append(gal)
    elif 'NO TEACHER' in engaged[gal]:
        galsfree.append(gal)
# print galsfree

for crn in engaged:
    if len(classes[crn][0]) >= 10:
        guysfree.append(engaged[crn])

#print guysfree
 

teacherassign = copy.deepcopy(teacher_keys)

for name in teacher_keys:
	if name in dummy_TA:
		teacherassign.remove(name)
	elif name not in engaged.values():
		teacherassign.remove(name)
	for klass in engaged:
		if 'NO CLASS' in klass and engaged[klass] == name:
			teacherassign.remove(name)

#for guy in guysfree:
#   if 'no' in guy.lower():
#       guysfree.remove(guy)

#for gal in galsfree:
#   if 'no' in gal.lower():
#       galsfree.remove(gal)

#print('\nCouples:')
#print('  ' + ',\n  '.join('%s is engaged to %s' % couple
#                          for couple in sorted(engaged.items())))
#print()
#print('Engagement stability check PASSED'
#      if check(engaged) else 'Engagement stability check FAILED')
 
#print('\n\nSwapping two fiances to introduce an error')
#engaged[gals[0]], engaged[gals[1]] = engaged[gals[1]], engaged[gals[0]]
#for gal in gals[:2]:
#    print('  %s is now engaged to %s' % (gal, engaged[gal]))
#print()
#print('Engagement stability check PASSED'
#      if check(engaged) else 'Engagement stability check FAILED')

#print('\n\nSwapping them back\n')
#engaged[gals[0]], engaged[gals[1]] = engaged[gals[1]], engaged[gals[0]]
#for gal in gals[:2]:
#    print('  %s is now engaged to %s' % (gal, engaged[gal]))
#print  

##This is the bit where it writes out to an xl file
finassign_sheet = output.add_sheet("Assignments Option #1")

finassign_sheet.write(0, 0, "Name")
finassign_sheet.write(0, 1, "Assignment Number")
finassign_sheet.write(0, 2, "Assignment")
finassign_sheet.write(0, 3, "Time")
#finassign_sheet.write(0, 3, "Discussion Room")

##This writes out the column of names
for name in range(len(teacherassign)):
    finassign_sheet.write(name+1, 0, teacherassign[name])

##This writes out the CRN
#for name in range(0, len(teacher_keys)):

for name in teacherassign:
    for pair in engaged:
        if engaged[pair] is name:
            finassign_sheet.write(teacherassign.index(name) + 1, 2, pair)
            finassign_sheet.write(teacherassign.index(name) + 1, 3, classstimes[pair])
            finassign_sheet.write(teacherassign.index(name) + 1, 1, classes[pair])      

finassign_sheet.write(len(teacherassign) + 3, 0, "Unassigned People")
finassign_sheet.write(len(teacherassign) + 3, 2, "Unassigned Assignment Number")
finassign_sheet.write(len(teacherassign) + 3, 3, "Unassigned Assignment")

for name in range(len(teacherassign) + 4, len(teacherassign) + len(guysfree) + 4):
    finassign_sheet.write(name, 0, guysfree[name - (len(teacherassign) + 4)])

for name in range(len(teacherassign) + 4, len(teacherassign) + len(galsfree) + 4):
    finassign_sheet.write(name, 3, galsfree[name - (len(teacherassign) + 4)])
    finassign_sheet.write(name, 2, classes[galsfree[name - (len(teacherassign) + 4)]])

##This writes out the CRN
#for name in teacher_keys:  #Teacher_keys is the list of all names 
#   if name in engaged:
#       finassign_sheet.write((teacher_keys.index(name)) + 1, 2, engaged[name])
#       for item in classes:
#           if engaged[name] in classes[item]:
#               finassign_sheet.write((teacher_keys.index(name)) + 1, 1, item)
#   else:
#       finassign_sheet.write((teacher_keys.index(name)) + 1, 2, 'No assignment')
#       finassign_sheet.write((teacher_keys.index(name)) + 1, 1, 'No assignment')

#######Department Optimal#######
guyprefers = class_pref
galprefers = teachers_pref

#this sorts the members of each sex alphabetically, I'm not fully certain why this is necessary
guys = sorted(guyprefers.keys())
gals = sorted(galprefers.keys())

guysfree = guys[:]


#this is another function that plays matchmaker
def matchmaker():
    engaged  = {}
    guyprefers2 = copy.deepcopy(guyprefers)
    galprefers2 = copy.deepcopy(galprefers)
    while guysfree:
        guy = guysfree.pop(0)
        guyslist = guyprefers2[guy]
        gal = guyslist.pop(0)
        fiance = engaged.get(gal)
        if not fiance:
            # She's free
            engaged[gal] = guy
            #print("  %s and %s" % (guy, gal))
        else:
            # The bounder proposes to an engaged lass!
            #print gal
            #print sorted(galprefers2.keys())
            galslist = galprefers2[gal]
            if guy in galslist:
                if galslist.index(fiance) > galslist.index(guy):
                    # She prefers new guy
                    engaged[gal] = guy
                    #print("  %s dumped %s for %s" % (gal, fiance, guy))
                    if guyprefers2[fiance]:
                        # Ex has more girls to try
                        guysfree.append(fiance)
                else:
                    # She is faithful to old fiance
                    if guyslist:
                        # Look again
                        guysfree.append(guy)
    return engaged

#this is where the program actually starts to run
#print('\nEngagements:')
engaged = matchmaker()

galsfree = []

for gal in gals:
    if gal not in engaged.keys() and gal not in dummy_TA:
        galsfree.append(gal)

for guy in guys: 
    if guy not in engaged.values():
        guysfree.append(guy) 

for ta in engaged.keys():
    if 'NO TEACHER' in ta:
        guysfree.append(engaged[ta])
    elif 'NO CLASS' in engaged[ta]:
        galsfree.append(ta)


teacherassign2 = copy.deepcopy(teacher_keys)

for name in teacher_keys:
	if name in dummy_TA:
		teacherassign2.remove(name)
	elif name not in engaged:
		teacherassign2.remove(name)
	elif 'NO CLASS' in engaged[name]:
		teacherassign2.remove(name)

#for guy in guysfree:
#   if 'no' in guy.lower():
#       guysfree.remove(guy)

#for gal in galsfree:
#   if 'no' in gal.lower():
#       galsfree.remove(gal)

#print('\nCouples:')
#print('  ' + ',\n  '.join('%s is engaged to %s' % couple
#                          for couple in sorted(engaged.items())))
#print('Engagement stability check PASSED')
 
#print('\n\nSwapping two fiances to introduce an error')
#engaged[gals[0]], engaged[gals[1]] = engaged[gals[1]], engaged[gals[0]]
#for gal in gals[:2]:
#    print('  %s is now engaged to %s' % (gal, engaged[gal]))
#print ('Engagement stability check PASSED')

#print('\n\nSwapping them back\n')
#engaged[gals[0]], engaged[gals[1]] = engaged[gals[1]], engaged[gals[0]]
#for gal in gals[:2]:
#    print('  %s is now engaged to %s' % (gal, engaged[gal]))
#print  

##This is the bit where it writes out to an xl file
finassign2_sheet = output.add_sheet("Assignments Option #2")

finassign2_sheet.write(0, 0, "Name")
finassign2_sheet.write(0, 1, "Assignment Number")
finassign2_sheet.write(0, 2, "Assignment")
finassign2_sheet.write(0, 3, "Time")
#finassign2_sheet.write(0, 3, "Discussion Room")

##This writes out the column of names
for name in range(len(teacherassign2)):
    finassign2_sheet.write(name+1, 0, teacherassign2[name])

##This writes out the CRN
for name in teacherassign2:  #Teacher_keys is the list of all names 
    finassign2_sheet.write((teacherassign2.index(name)) + 1, 2, engaged[name])
    finassign2_sheet.write(teacherassign2.index(name) + 1, 3, classstimes[engaged[name]])
    finassign2_sheet.write((teacherassign2.index(name)) + 1, 1, classes[engaged[name]][0])
        

finassign2_sheet.write(len(teacherassign2) + 3, 0, "Unassigned People")
finassign2_sheet.write(len(teacherassign2) + 3, 2, "Unassigned Assignment Number")
finassign2_sheet.write(len(teacherassign2) + 3, 3, "Unassigned Assignment")

for name in range(len(teacherassign2) + 4, len(teacherassign2) + len(galsfree) + 4):
    finassign2_sheet.write(name, 0, galsfree[name - (len(teacherassign2) + 4)])

for name in range(len(teacherassign2) + 4, len(teacherassign2) + len(guysfree) + 4):
    finassign2_sheet.write(name, 3, guysfree[name - (len(teacherassign2) + 4)])
    finassign2_sheet.write(name, 2, classes[guysfree[name - (len(teacherassign2) + 4)]])

#   for pair in engaged:
#       if engaged[pair] is teacher_keys[name]:
#           finassign_sheet.write(name+1, 2, pair)
#           for item in classes:
#               if pair in classes[item]:
#                   finassign_sheet.write(name+1, 1, item)      

filename = (inputs.split('.'))[0]

output.save(filename + 'final.xls')

print '\nAnalysis completed.'
print 'The output file, "' + filename + 'final.xls," has been uploaded to your current directory.'





