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



#####Reads in a dictionary of class names to CRN
def addsCRNsToClasses(sheet_classes, class_num, classes):
	crn = 1
	class_shortage = 0
	if (sheet_classes.nrows - 1) < class_num:
		class_shortage = class_num - (sheet_classes.nrows - 1)
	while crn < sheet_classes.nrows + class_shortage + 1:
		if crn < sheet_classes.nrows:    
			j = sheet_classes.cell(crn, 1).value # The class section name
			if isinstance(j, (int, long, float, complex)):
				j = unicode(int(j))
			i = sheet_classes.cell(crn, 0).value # The CRN
			if isinstance(i, (int, long, float, complex)):
				i = unicode(int(i)) 
			classes[j] = i
	
		elif class_shortage != 0:
			if crn > (sheet_classes.nrows + class_shortage - 1):
				classes[unicode('NO CLASS ' + str(crn - sheet_classes.nrows))] = []    
		crn+=1
#####


#####
def addsDummytoClassPref(class_pref, dummy_TA):
	for crn in class_pref:
		class_pref[crn].extend(dummy_TA)
#####


#####Adds duplicates of teachers--based on the number of classes they need to teach--
# to the class_pref dictionary
def addDuplicatestoClassPref(class_names, class_pref, numbers):
	
	for klass in class_names:  #Cycles through the list of the class names
		for item in class_pref[klass]:  #Links the class name to the randomized list 
										#of TAs put in preference order
			j = class_pref[klass].index(item)
			temp = []
			if int(numbers[item]) > 1:
				num_classes = 1
				temp.append(item + ' ' + str(num_classes))
				while num_classes < int(numbers[item]):
					temp.append(item + ' ' + str(num_classes+1))  
					num_classes+=1   
				class_pref[klass][j] = temp
		class_pref[klass] = list(flatten(class_pref[klass])) 
#####


#####
def addDummysToClasses(dummy_classes, classes):
	for dummy in dummy_classes:
		classes[dummy].append(unicode(random.randint(1000000000, 9999999999)))
#####

#####Adds duplicates to the blacklist, splits teacher's names based on the number of
# classes they will be teaching.  Makes the keys of every dictionary the same
def addsDuplicatesToBlacklist(blacklist, numbers):
	black = sorted(blacklist.keys())

	for item in black:
		j = black.index(item)
		if blacklist[item]:
			for name in blacklist[item]:
				i = blacklist[item].index(name)
				if int(numbers[name]) > 1:
					num_classes = 1
					more = []           
					more.append(blacklist[item][i] + ' ' + str(1))
					while num_classes < int(numbers[name]):
						blacklist[item][i] 
						more.append(blacklist[item][i] + ' ' + str(num_classes + 1))
						num_classes+=1
					blacklist[item][i] = more
					blacklist[item] = list(flatten(blacklist[item]))
#####


#####Adds duplicates to teachers_pref dict according to number of classes to be taught
def addDuplicatestoTeachersPref(sheet_teacher, teachers_pref):
	for name in range(1, sheet_teacher.nrows):
		k = int(sheet_teacher.cell(name, 4).value)
		if k > 1:
			num_classes = 1
			while num_classes < k:
				teachers_pref[(sheet_teacher.cell(name, 0).value) + ' ' + str(num_classes + 1)] = copy.copy(teachers_pref[sheet_teacher.cell(name, 0).value])
				teachers_pref[(sheet_teacher.cell(name, 0).value) + ' ' + str(num_classes)] = copy.copy(teachers_pref[sheet_teacher.cell(name, 0).value])
				num_classes+=1
			del teachers_pref[(sheet_teacher.cell(name, 0).value)]
#####


#####Checks input to see if everything is fine
def checkInput(sheet_teacher, sheet_classes): 
	units  = 1
	while units < (sheet_teacher.nrows):
	    if isinstance(sheet_teacher.cell(units, 4).value, float) and sheet_teacher.cell(units,4).value % 1 == 0:
	        if isinstance(sheet_teacher.cell(units, 5).value, float) and sheet_teacher.cell(units,5).value % 1 == 0:
	            units+=1
	        else:
	            print ("\nYou may have entered a non-integer in the 'Ranking' column on the first sheet, line",str(units+1)+". Please edit your excel file accordingly!")
	            sys.exit("PLEASE EDIT YOUR EXCEL FILE!")
	    else:
	        print ("You may have entered a non-integer in the fifth column on the first sheet, line",str(units+1)+". Please edit your excel file accordingly!")
	        sys.exit("PLEASE EDIT YOUR EXCEL FILE!")

	units = 1
	while units < (sheet_classes.nrows):
	    if isinstance(sheet_classes.cell(units, 0).value, float) and sheet_classes.cell(units,0).value % 1 == 0:
	        if isinstance(sheet_classes.cell(units,3).value, float) and sheet_classes.cell(units,3).value % 1 == 0:
	            units+=1
	        else:
	            print ("You may have entered a non-integer in the 'Rankings' column on the second sheet, line",str(units+1)+". Please edit your excel file accordingly!")
	            sys.exit("PLEASE EDIT YOUR EXCEL FILE!")
	    else:
	        print ("You may have entered a non-integer in the 'CRNs' column on the second sheet, line",str(units+1)+". Please edit your excel file accordingly!")
	        sys.exit("PLEASE EDIT YOUR EXCEL FILE!")
#####


#####Generates the blacktime dictionary, based on comparing TAconflicts and class_times
def comparesTAconflictsClassTimes(TA, TAconflicts, class_times, blacktime):
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
				i+=1
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
		if class_times[crn]: 
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
			if time in class_times[crn]: # check if TA time conflict agrees with class time
				if TA in blacktime[crn]: # check if TA name is already there, if it is
					break # Don't add another duplicate of the TA name
				blacktime[crn].append(TA) # add TA name to CRN of class they cannot teach
#####


#####Generates 2 lists: arbitrary TAs and classes, to set equal the number of TAs and classes. 
def dummy(sheet_classes, class_num, dummy_classes, dummy_TA):
	TA_shortage = 0
	class_shortage = 0
	if (sheet_classes.nrows - 1) < class_num:
		class_shortage = class_num - (sheet_classes.nrows - 1)
		for num in range(class_shortage):
			dummy_classes.append(unicode('NO CLASS ' + str(num + 1)))

	elif (sheet_classes.nrows - 1) > class_num:
		TA_shortage = (sheet_classes.nrows - 1) - class_num
		for num in range(TA_shortage):
			dummy_TA.append(unicode('NO TEACHER ' + str(num + 1)))
	return TA_shortage
#####


#####Writes out to the excel file the names of the teachers who have been assigned
def excelNames(finassign_sheet, teacherassign):
	for name in range(len(teacherassign)):
		finassign_sheet.write(name+1, 0, teacherassign[name])
#####


#####Writes out to the second sheet of the excel file the names of the teachers who 
# have been assigned
def excelNames2(finassign2_sheet, teachersassign2):
	for name in range(len(teachersassign2)):	
		finassign2_sheet.write(name+1, 0, teachersassign2[name])
#####


#####Writes out to the first xl sheet the names of the sections, their times and crns
def excelSectionsTimesCRNS(teacherassign, finassign_sheet, engaged, classstimes, classes):
	for name in teacherassign:
		for pair in engaged:
			if engaged[pair] is name:
				# writes out all the section names
				finassign_sheet.write(teacherassign.index(name) + 1, 2, pair) 
				# writes out all the class times
				finassign_sheet.write(teacherassign.index(name) + 1, 3, classstimes[pair])
				# writes out all the assignment crns
				finassign_sheet.write(teacherassign.index(name) + 1, 1, classes[pair])  
#####


#####Writes out to the second xl sheet the names of the sections, their times and crns
def excelSectionsTimesCRNS2(teachersassign2, finassign2_sheet, engaged, classstimes, classes):	
	for name in teachersassign2:  #Teacher_keys is the list of all names 
		# writes out all the section names
		finassign2_sheet.write((teachersassign2.index(name)) + 1, 2, engaged[name])
		# writes out all the class times
		finassign2_sheet.write(teachersassign2.index(name) + 1, 3, classstimes[engaged[name]])
		# writes out all the assignment crns
		finassign2_sheet.write((teachersassign2.index(name)) + 1, 1, classes[engaged[name]])



#####
def excelUnassigned(finassign_sheet, teacherassign, guysfree, galsfree, classes):
	finassign_sheet.write(len(teacherassign) + 3, 0, "Unassigned People")
	finassign_sheet.write(len(teacherassign) + 3, 2, "Unassigned Assignment Number")
	finassign_sheet.write(len(teacherassign) + 3, 3, "Unassigned Assignment")

	#writes out the names of unassigned teachers
	for name in range(len(teacherassign) + 4, len(teacherassign) + len(guysfree) + 4):
		finassign_sheet.write(name, 0, guysfree[name - (len(teacherassign) + 4)])

	for name in range(len(teacherassign) + 4, len(teacherassign) + len(galsfree) + 4):
		#writes out the names of unassigned sections
		finassign_sheet.write(name, 3, galsfree[name - (len(teacherassign) + 4)])
		#writes out the CRNs of unassigned sections
		finassign_sheet.write(name, 2, classes[galsfree[name - (len(teacherassign) + 4)]])
#####


#####
def excelUnassigned2(finassign2_sheet, teachersassign2, guysfree, galsfree, classes):
	finassign2_sheet.write(len(teachersassign2) + 3, 0, "Unassigned People")
	finassign2_sheet.write(len(teachersassign2) + 3, 2, "Unassigned Assignment Number")
	finassign2_sheet.write(len(teachersassign2) + 3, 3, "Unassigned Assignment")

	# writes out the names of unassigned teachers
	for name in range(len(teachersassign2) + 4, len(teachersassign2) + len(galsfree) + 4):
		finassign2_sheet.write(name, 0, galsfree[name - (len(teachersassign2) + 4)])

	for name in range(len(teachersassign2) + 4, len(teachersassign2) + len(guysfree) + 4):
		# writes out the names of the unassigned sections
		finassign2_sheet.write(name, 3, guysfree[name - (len(teachersassign2) + 4)])
		# writes out the CRNs of unassigned sections
		finassign2_sheet.write(name, 2, classes[guysfree[name - (len(teachersassign2) + 4)]])
#####




#####Appends to guysfree and galsfree those guys and gals not engaged
def figuresOutGuysAndGalsFree(gals, galsfree, guys, guysfree, engaged, dummy_TA):
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
#####


#####
def fillsClassPref(rankings, class_names, class_pref):
	rank = sorted(rankings.keys())
	for klass in class_names:
		for item in rank:
			teach = len(rankings[item])
			class_pref[klass].extend(random.sample(rankings[item][:teach], teach))

#####

#####
def fillsRankings(sheet_teacher, rankings):
	rank = 1
	for rank in range(1, sheet_teacher.nrows):
		i = sheet_teacher.cell(rank, 5).value 	# the ranking
		j = sheet_teacher.cell(rank, 0).value 	# the name
		rankings[unicode(int(i))].append(j)
#####


#####Constructs guysfree and galsfree for the TA Optimal stuff
def findsGuysandGalsFree(guys, guysfree, gals, galsfree, dummy_TA, engaged, classes):
	#adds unengaged guys to guysfree	
	for guy in guys:
		if guy not in engaged.values() and guy not in dummy_TA:
			guysfree.append(guy)

	#adds unengaged gals to galsfree
	for gal in gals:
		if gal not in engaged.keys():
			galsfree.append(gal)
		elif 'NO TEACHER' in engaged[gal]:
			galsfree.append(gal)

	#in case a guy is engaged to NO CLASS--where the CRN is 10+ digits long--he'll 	
	#get added to guysfree
	for crn in engaged:
		if len(classes[crn][0]) >= 10:
			guysfree.append(engaged[crn])
#####	


#####It takes a list of lists, and flattens it into just a single list
def flatten(L):
	It = collections.Iterable
	for e in L:
		if isinstance(e, It) and not isinstance(e, basestring):
			for sub in flatten(e):
				yield sub
		else:
			yield e
#####


#####Reads in the blacklist from the xl sheet
def makesBlacklist(sheet_classes, blacklist, classrank, dummy_TA):
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
#####

#####Generates the skeleton of the blacktime (the time conflict blacklist) dict
def makesBlackTime(class_times, blacktime):
	for crn in class_times:
		blacktime[crn] = []
####


#####Makes the skeleton of the class preference dictionary
def	makesClasses(sheet_classes, classes, class_num):
	class_name = 1
	class_shortage = 0
	if (sheet_classes.nrows - 1) < class_num:
		class_shortage = class_num - (sheet_classes.nrows - 1)
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
#####


#####Starts the class_prf dictionary with class names as keys
def makesClassPrefSkeleton(class_names,class_pref):
	for klass in class_names:
		class_pref[klass] = []
#####


#####Parses each classstimes value into a list
def makesClassTimes(classstimes, classtimes):
	for class_name in classstimes:
		times = classstimes[class_name].split(",")
		for name in times:
			if name:
				j = times.index(name)
				if name[0] == ' ':
					times[j] = name[1:]
			classtimes[class_name] = times
#####



#####Makes the class_times dictionary for the time conflicts code
def makesClass_Times(time, class_times, classs):
	k = len(time)
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
#####
def makesIndifs(teacher, class_names, teachers_like, teachers_hate, teachers_indif):
	for name in teacher:
		for klass in class_names:
			if((klass not in teachers_like[name]) and (klass not in 
				teachers_hate[name])):
				teachers_indif[name].append(klass)
#####


#####
def makesTAconflicts(randoms, TA, TAconflicts):
	k = len(randoms)
############STEP 2: Create a dictionary using the split up string
	i = 0
	TAconflicts[TA] = []

	while i < k:# make sure you don't go outside range of list (length k)
		for day in randoms[i][0]:# randoms[0][0] = ['M', 'W', 'F'], randoms[1][0] = ['T', 'R']
			for time in randoms[i]: # random[i] is a list of days
				TAconflicts[TA].append([day,time]) # add a list of lists to current TA
		i+=1 # iterate i by 1 (next list of days)
            
	for tupleton in TAconflicts[TA]: # removes all entries where the second element is a list of days
		if tupleton[1] == u'' or tupleton[1][0] in Days: # if first entry in list has a day entry...
			TAconflicts[TA].remove(tupleton) # remove that tupleton from the list of time conflicts
#####


#####Makes the skeleton of the teachers' preference dictionary, it also appends in the fake TAs that we made earlier
def makesTeachers(sheet_teacher, teachers, TA_shortage, dummy_TA): 
	teacher_name = 1
	while teacher_name < (sheet_teacher.nrows + TA_shortage + 1):
		if teacher_name < sheet_teacher.nrows:
			teachers[sheet_teacher.cell(teacher_name, 0).value] = []
		elif TA_shortage != 0:
			if teacher_name > sheet_teacher.nrows - 1:
				teachers[dummy_TA[(teacher_name - sheet_teacher.nrows) - 1]] = [] 
		teacher_name+=1
#####


#####
def makesTeachersHateOnlySectionNames(teacher, teachers_hate, sections, temp):
	for one in teacher:
		for item in teachers_hate[one]:
			j = item.split('-')
			if j[0] not in sections.keys():
				teachers_hate[one].remove(item)
				break
			elif len(j) == 1:
				item = sections[j[0]]
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
#####


#####
def makesTeachersLikeOnlySectionNames(teacher, teachers_like, sections, temp):
	for one in teacher:
		for item in teachers_like[one]:
			j = item.split('-')
			if j[0] not in sections.keys():
				teachers_like[one].remove(item)
				break
			elif len(j) == 1:
				item = sections[j[0]]
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
#####



#####
def makesTeachersPref(teachers, teachers_pref, teachers_like, teachers_hate, 		
		teachers_indif):
	for name in teachers:
		teachers_pref[name] = []
		teachers_pref[name].extend(teachers_like[name])

		#randomizes the indifs:
		teach = len(teachers_indif[name])
		lyst = random.sample(teachers_indif[name][:teach], teach)

		teachers_pref[name].extend(lyst)   
		teachers_pref[name].extend(teachers_hate[name])
		while '' in teachers_pref[name]:
			teachers_pref[name].remove('')
#####


#####
def matchmaker(guyprefers, galprefers, guys, gals, guysfree):
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
		else:
			# The bounder proposes to an engaged lass!
			galslist = galprefers2[gal]
			if guy in galslist:
				if galslist.index(fiance) > galslist.index(guy):
					# She prefers new guy
					engaged[gal] = guy
					if guyprefers2[fiance]:
						# Ex has more girls to try
						guysfree.append(fiance)
				else:
					# She is faithful to old fiance
					if guyslist:
						# Look again
						guysfree.append(guy)
	return engaged
#####


#####
def processRandoms(randoms):
	i = 0
	for randomss in randoms:
		sorted_list = randomss.split(" ")
		randoms[i] = sorted_list
		i = i+1 # splitting by spaces
	j = 0
	for item in randoms:
		for string in randoms[j]:
			if string.isalpha():
				randoms[j][randoms[j].index(string)] = list(string)
		j+=1 #making a sublist for strings that are entirely alphabetical
#####


#####
def readsBlacklistSkeleton(sheet_classes, blacklist):
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
#####

#####Creates a list of class section names
def readsClassNames(sheet_classes, class_names):
	j = 1
	while j < sheet_classes.nrows:
		k = sheet_classes.cell(j, 1).value
		if isinstance(k, (int, long, float, complex)):
			k = unicode(int(k))
		else:
			k = unicode(k)
		class_names.append(k)
		j+=1
#####


#####Read in class ranking using section name as key
def readsClassRank(sheet_classes, classrank):
	j = 1
	while j < sheet_classes.nrows:
		k = sheet_classes.cell(j, 1).value
		if isinstance(k, (int, long, float, complex)):
			k = unicode(int(k))
		classrank[k] = unicode(int(sheet_classes.cell(j, 3).value))
		j += 1
#####


#####Makes a dictionary class times, with section names as keys
def	readsClasssTimes(sheet_classes, classstimes):
	j = 1
	while j < sheet_classes.nrows:
		k = sheet_classes.cell(j, 1).value
		if isinstance(k, (int, long, float, complex)):
			k = unicode(int(k))
		classstimes[k] = sheet_classes.cell(j, 2).value
		j += 1
#####

#####Reads in TA conflicts, ie times they are unavailable
def readsConflicts(sheet_teacher, TA_conflicts):
	i = 1
	while i < sheet_teacher.nrows:
		if sheet_teacher.cell(i,  3).ctype is not empty_cell:
			TA_conflicts[sheet_teacher.cell(i, 0).value] = sheet_teacher.cell(i, 3).value
		i += 1    
#####


#####Generates a dictionary of how many classes each teacher will teach
def readsNumberofClasses(sheet_teacher, numbers, TA_shortage, dummy_TA):
	units = 1
	while units < (sheet_teacher.nrows):
		numbers[sheet_teacher.cell(units, 0).value] = unicode(int(sheet_teacher.cell(units,4).value))
		units+=1
	if TA_shortage != 0:
		for dummy in dummy_TA:
			numbers[dummy] = unicode(1)
#####


#####This generates the skeleton of the blacklist using section names
def readsBlacklistSkeleton(sheet_classes, blacklist):
	black = 1
	while black < sheet_classes.nrows:
		j = sheet_classes.cell(black, 1).value
		if isinstance(j, (int, long, float, complex)):
			j = unicode(int(j))
		if j not in blacklist:
			blacklist[j] = []
		black+=1
#####


#####Generates the skeleton of the rankings dictionary, with the rank number as keys
def readsRankingsSkeleton(sheet_teacher, rankings):
	rank = 1
	while rank < sheet_teacher.nrows:
		i = sheet_teacher.cell(rank, 5).value
		rankings[unicode(int(i))] = []
		rank+=1
#####

#####
def readsTeachersLikes(sheet_teacher, teachers_like):
	like = 1
	while like < sheet_teacher.nrows:
		if sheet_teacher.cell(like, 1).ctype is not empty_cell:
			temp_list = []
			i = unicode(str(sheet_teacher.cell(like, 1).value))
			j = unicode(str(sheet_teacher.cell(like, 0).value))
			teachers_like[j].append(i)
			teachers_like[j] = (i).split(', ')
		like+=1
#####


#####
def readsTeachersHates(sheet_teacher, teachers_hate):
	hate = 1
	while hate < sheet_teacher.nrows:
		if sheet_teacher.cell(hate, 2).ctype is not empty_cell:
			temp_list = []
			j = unicode(str(sheet_teacher.cell(hate, 0).value))
			i = unicode(str(sheet_teacher.cell(hate, 2).value))
			teachers_hate[j].append(i)
			teachers_hate[j] = (i).split(', ')
		hate+=1
#####


#####If a teacher is blacklisted for a class, we remove that class from their 
# preference dictionary
def removeClassesFromTeachersPref(blacklist, teachers_pref, teacher_keys):
	black = sorted(blacklist.keys())
	for person in teacher_keys: #loops through all the teachers
		for item in black:  #loops through the keys of the blacklist
			for each in blacklist[item]:  #loops through the corresponding values
				if person == each:  
					teachers_pref[person].remove(item)
#####


#####emoves those empty strings from our blacklist. 
def removesEmptyStringsFromBlacklist(blacklist, blacktime):
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
#####


#####
def removesFromTeachersHateClassesThatDontExist(teacher, class_names, teachers_hate):
	for one in teacher:	
		temp = []
		for item in teachers_hate[one]:
			if item not in class_names:
				temp.append(item)	

		for item in temp:
			teachers_hate[one].remove(item)
#####	

#####
def removesFromTeachersLikeClassesThatDontExist(teacher, class_names, teachers_like):
	for one in teacher:	
		temp = []
		for item in teachers_like[one]:
			if item not in class_names:
				temp.append(item)	

		for item in temp:
			teachers_like[one].remove(item)
#####


#####Loops through the blacklist and if there is a TA who is not on the TA sheet,
# it removes him from the blacklist
def removesTAswhodontexist(teachers, blacklist):
	teachers_list = sorted(teachers.keys())
	black = sorted(blacklist.keys())

	for item in black:
		if blacklist[item]:
			temp_list = []
			for name in range(len(blacklist[item])):
				if blacklist[item][name] not in teachers_list:
					print ('\n' + blacklist[item][name],'is not listed as a teacher or TA. He or she was listed as part of the blacklist for',item+'.')
					print ("Please edit your excel file accordingly. Thank you.")
					sys.exit("IGNORE THIS ERROR. The program ran fine.")
#####


#####Remove the tas from each class in class_prefs list for which they're blacklisted
def removeTeachersFromClassPref(blacklist, classes, class_pref):
	black = sorted(blacklist.keys())
	classs = sorted(classes.keys())
	for item in black:
		j = black.index(item)
		if blacklist[item]:
			for name in blacklist[item]:
				class_pref[item].remove(name)
#####


#####
def reversesTeachersHateExtendsDummys(teachers_hate, dummy_classes):
	for ta in teachers_hate:
		teachers_hate[ta].reverse()
	
	for ta in teachers_hate:
		teachers_hate[ta].extend(dummy_classes)
#####	


#####Saves the assignment xl file to the user's current directory
def savesFinalExcel(inputs, output):
	filename = (inputs.split('.'))[0]

	output.save(filename + ' final.xls')

	print ('\nAnalysis completed.')
	print ('The output file, "' + filename + ' final.xls," has been uploaded to your current directory.')
#####


#####Removes from teacherassign those names of teachers that didn't get assigned
def simplifiesTeacherAssign(teacherassign, teacher_keys, dummy_TA, engaged):
	for name in teacher_keys:
		if name in dummy_TA:
			teacherassign.remove(name)
		elif name not in engaged.values():
			teacherassign.remove(name)
		for klass in engaged:
			if 'NO CLASS' in klass and engaged[klass] == name:
				teacherassign.remove(name)
#####


#####
def simplifiesTeacherAssign2(teacherassign2, teacher_keys, dummy_TA, engaged):
	for name in teacher_keys:
		if name in dummy_TA:
			teacherassign2.remove(name)
		elif name not in engaged:
			teacherassign2.remove(name)
		elif 'NO CLASS' in engaged[name]:
			teacherassign2.remove(name)
#####


#####Creates the sections dictionary
def splitsClassNames(class_names, sections):
	#Generates the keys of the outter-most dictionary
	for i in range(len(class_names)):
		temp = class_names[i].split('-')
		sections[temp[0]] = {}

	##Generates the keys of the inner dictionary
	for i in range(len(class_names)):
		temp = class_names[i].split('-')
		if len(temp) == 3:
			sections[temp[0]][temp[0]+'-'+temp[1]] = []

	##Assigns the individual sections to the separate lectures
	for i in range(len(class_names)):
		temp = class_names[i].split('-')
		if len(temp) == 3:
			sections[temp[0]][temp[0]+'-'+temp[1]].append(class_names[i])
#####


#####
def splitsClassTimes(classtimes, classs):
	i = 0
	time = classtimes[classs]
	for item in time:
		sorted_list = item.split(" ")
		time[i] = sorted_list
		i+=1

	j = 0
	for items in time:
		for string in time[j]:
			if string.isalpha():
				time[j][time[j].index(string)] = list(string)
		j += 1
	return time
#####


#####
def startsExcelFile(output):
	finassign_sheet = output.add_sheet("Assignments Option #1")
	
	finassign_sheet.write(0, 0, "Name")
	finassign_sheet.write(0, 1, "Assignment")
	finassign_sheet.write(0, 2, "Assignment Number")
	finassign_sheet.write(0, 3, "Time")
		
	return finassign_sheet
#####


#####
def startsExcelFile2(output):
	finassign2_sheet = output.add_sheet("Assignments Option #2")
	
	finassign2_sheet.write(0, 0, "Name")
	finassign2_sheet.write(0, 1, "Assignment")
	finassign2_sheet.write(0, 2, "Assignment Number")
	finassign2_sheet.write(0, 3, "Time")
		
	return finassign2_sheet
#####


#####Totals the number of classes
def totalNumberofClasses(sheet_teacher):
	units = 1
	class_num = 0
	while units < (sheet_teacher.nrows):
		class_num += int(sheet_teacher.cell(units, 4).value)
		units+=1    
	return class_num
#####




def main():

	#Lists of dummy TAs and classes, used to make the algorithm square	
	dummy_classes = []
	dummy_TA = []

	TA_conflicts = {} 	#  TEMP Dictionary linking TAs with times they are unavailable
	class_names = []  	#  List of all of the class names
	sections = {} 		#  A nested dictionary linking class names to lectures to 
						#sections. ie: 17A -> 17A-a -> 17A-a-01
	classstimes = {} 	#  Dictionary of classnames to classtimes, identical to the 
						#input format, to be used in the output.
	classtimes = {}	 	#  TEMP Dictionary linking classnames with times
	classrank = {} 		#  Dictionary of class names to rank entry for adding dummy  
						#tas to blacklist of advanced classes
	teachers = {}   	#  Empty dictionary with teacher names as keys
	classes = {}    	#  Empty dictionary with class names as keys
	numbers = {} 		#  Dictionary linking teachers' name to the # classes they
						#need to teach
	class_times = {} 	#  Dictionary linking class names with times
	blacktime = {} 		#  Dictionary for time conflicts
	TAconflicts = {} 	#  REAL Dictionary linking TAs with class names they cannot 
						#teach
	blacklist = {}  	#  The blacklist dictionary
	teachers_like = {}	#  All three of these dictionaries are temporary dictionaries
	teachers_hate = {}	#that we construct and then use to generate the teachers_pref
	teachers_indif = {}	#dictionary
	teachers_pref = {}	#  The final preference dict for teachers used in the algorithm
	rankings = {}		#  Dictionary for teachers rankings
	class_pref = {}		#  The final preference dictionary used in the algorithm


	inputs = raw_input('\nPlease specify the name of the file you wish to have analyzed (Must be in the same directory as the program): ')

	book = xlrd.open_workbook(inputs)
	output = xlwt.Workbook()

	sheet_teacher = book.sheet_by_index(0)
	sheet_classes = book.sheet_by_index(1)

	checkInput(sheet_teacher, sheet_classes)
	class_num = totalNumberofClasses(sheet_teacher) #returns total num of classes
	TA_shortage = dummy(sheet_classes, class_num, dummy_classes, dummy_TA)
	readsConflicts(sheet_teacher, TA_conflicts)	
	readsClassNames(sheet_classes, class_names)
	splitsClassNames(class_names, sections)
	readsClasssTimes(sheet_classes, classstimes)
	makesClassTimes(classstimes, classtimes)
	readsClassRank(sheet_classes, classrank)
	makesTeachers(sheet_teacher, teachers, TA_shortage, dummy_TA) 
	makesClasses(sheet_classes, classes, class_num)
	readsNumberofClasses(sheet_teacher, numbers, TA_shortage, dummy_TA)

	for classs in classtimes:
		time = splitsClassTimes(classtimes, classs)
		makesClass_Times(time, class_times, classs)

	makesBlackTime(class_times, blacktime)

	for TA in TA_conflicts:
		conflicts = TA_conflicts[TA]		
		randoms = conflicts.split(", ")
		processRandoms(randoms)
		makesTAconflicts(randoms, TA, TAconflicts)
		comparesTAconflictsClassTimes(TA, TAconflicts, class_times, blacktime)
	
	readsBlacklistSkeleton(sheet_classes, blacklist)	
	makesBlacklist(sheet_classes, blacklist, classrank, dummy_TA)
	removesEmptyStringsFromBlacklist(blacklist, blacktime)
	removesTAswhodontexist(teachers, blacklist)
	addsDuplicatesToBlacklist(blacklist, numbers)
	addsCRNsToClasses(sheet_classes, class_num, classes)
	addDummysToClasses(dummy_classes, classes)

	teachers_like = copy.deepcopy(teachers) 	# teachers is just an empty dictionary
	teachers_hate = copy.deepcopy(teachers)		# with the teachers' names as keys
	teachers_indif = copy.deepcopy(teachers)	# this makes independant copies of that
												# dictionary so we can read in the 
												# teachers' preferences

	classs = copy.deepcopy(class_names)			# makes a copy of the class_names
												# without changing that list 

	classs.extend(dummy_classes)				# Tacks the list of dummy_classes
	class_names.extend(dummy_classes)			# onto both classs and class_names
	
	readsTeachersLikes(sheet_teacher, teachers_like)

	teacher = sorted(teachers_like.keys())
	
	temp = {}						# Sets up a temporary dictionary that will help us
	temp = copy.deepcopy(teachers)	# manipulate the teachers_like dictionary

	makesTeachersLikeOnlySectionNames(teacher, teachers_like, sections, temp)
	removesFromTeachersLikeClassesThatDontExist(teacher, class_names, teachers_like)
	readsTeachersHates(sheet_teacher, teachers_hate)
	makesTeachersHateOnlySectionNames(teacher, teachers_hate, sections, temp)
	removesFromTeachersHateClassesThatDontExist(teacher, class_names, teachers_hate)
	reversesTeachersHateExtendsDummys(teachers_hate, dummy_classes)	
	makesIndifs(teacher, class_names, teachers_like, teachers_hate, teachers_indif)
	makesTeachersPref(teachers, teachers_pref, teachers_like, teachers_hate, 		
		teachers_indif)
	readsRankingsSkeleton(sheet_teacher, rankings)
	fillsRankings(sheet_teacher, rankings)
	makesClassPrefSkeleton(class_names,class_pref)
	fillsClassPref(rankings, class_names, class_pref)
	
	addDuplicatestoClassPref(class_names, class_pref, numbers)
	addsDummytoClassPref(class_pref, dummy_TA)
	addDuplicatestoTeachersPref(sheet_teacher, teachers_pref)

	teacher_keys = sorted(teachers_pref.keys())

	removeClassesFromTeachersPref(blacklist, teachers_pref, teacher_keys)
	removeTeachersFromClassPref(blacklist, classes, class_pref)

	### TA Optimal ###	
	guyprefers = teachers_pref
	galprefers = class_pref

	guys = sorted(guyprefers.keys())
	gals = sorted(galprefers.keys())

	guysfree = guys[:]
	galsfree = []

	engaged = matchmaker(guyprefers, galprefers, guys, gals, guysfree)
	findsGuysandGalsFree(guys, guysfree, gals, galsfree, dummy_TA, engaged, classes)

	teacherassign = copy.deepcopy(teacher_keys)

	simplifiesTeacherAssign(teacherassign, teacher_keys, dummy_TA, engaged)

	finassign_sheet = startsExcelFile(output)
	excelNames(finassign_sheet, teacherassign)
	excelSectionsTimesCRNS(teacherassign, finassign_sheet, engaged, classstimes, classes)
	excelUnassigned(finassign_sheet, teacherassign, guysfree, galsfree, classes)


	### Department Optimal ###
	guyprefers = class_pref
	galprefers = teachers_pref

	guys = sorted(guyprefers.keys())
	gals = sorted(galprefers.keys())

	guysfree = guys[:]

	engaged = matchmaker(guyprefers, galprefers, guys, gals, guysfree)

	galsfree = []
	figuresOutGuysAndGalsFree(gals, galsfree, guys, guysfree, engaged, dummy_TA)

	teachersassign2 = copy.deepcopy(teacher_keys)
	simplifiesTeacherAssign2(teachersassign2, teacher_keys, dummy_TA, engaged)
	finassign2_sheet = startsExcelFile2(output)	
	excelNames2(finassign2_sheet, teachersassign2)
	excelSectionsTimesCRNS2(teachersassign2, finassign2_sheet, engaged, classstimes, classes)	
	excelUnassigned2(finassign2_sheet, teachersassign2, guysfree, galsfree, classes)

	savesFinalExcel(inputs, output)
		

main()
