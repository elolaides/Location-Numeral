#Angelo Blades
#locationN.py
#this is a program to figure out how to convert from 
#number to location numeral or the other way around.
#Also, it simplifies location numerals


def getLetter(twopower):
	letters = 'abcdefghijklmnopqrstuvwxyz'
	return letters[twopower]
def getPower(letter):
	letters = 'abcdefghijklmnopqrstuvwxyz'
	number = 0
	for l in letters:
		if letter == l:
			break
		number += 1
	return number	
def simp(LN):
	dictLN = {}
	simplifiedLN = ""
	for l in LN:
		if l in dictLN:
			dictLN[l]+= 1
		else:
			dictLN[l] = 1
		
	for n in sorted(dictLN):
		if dictLN[n] == 0:
			del dictLN[n]
		elif dictLN[n]%2 == 0:
			if(getLetter(getPower(n)+1)) in dictLN:
				dictLN[getLetter(getPower(n)+1)] += dictLN[n]//2
			else:
				dictLN[getLetter(getPower(n)+1)] = dictLN[n]//2
			
			dictLN[n] = 0
		elif dictLN[n]%2 == 1:
			if(getLetter(getPower(n)+1)) in dictLN:
				dictLN[getLetter(getPower(n)+1)] += dictLN[n]//2
			else:
				dictLN[getLetter(getPower(n)+1)] = dictLN[n]//2
			
			dictLN[n] = 1
			
	for letter in sorted(dictLN):
		if dictLN[letter] > 0:
			for i in range(dictLN[letter]):
				simplifiedLN += letter
	return simplifiedLN
def convertToLN(number):
	LN = ""
	twopower = 0
	while number > 0:
		if number >= 2**twopower:
			LN = LN + getLetter(twopower)
			number -= 2**twopower
			twopower += 1
		else:
			twopower -=1
			
	return simp(LN)
def convertToNumber(LN):
	LN = simp(LN)
	number = 0
	for n in LN:
		number += 2**getPower(n)
	return number
def main():
	print "Let's convert some numbers or letters"
	number = input("Enter Number:")
	LN = str(raw_input("Enter LN:"))
	print convertToLN(number)
	print convertToNumber(LN)
	
main()