#      Stack and Queue
#      Dunder metodlari


# class Stack:
#     def __init__(self):
#         self.elementlar = []
#     def push(self , element):
#         self.elementlar.append(element)
#         print(f"{element} listga qoshildi")

#     def pop(self):
#         print(f"{self.elementlar[-1]} dan O'chirildi")
#         self.elementlar.pop()
        

# a = Stack()
# a.push("Ziyodullo")
# a.push("azim")
# print(a.elementlar)
# a.pop()
# print(a.elementlar)


# class math:
#     def __init__(self, son):
#         self.son = son
        
#     def qoshuv(self, raqam):
#         self.raqam = raqam
#         qoshish = self.raqam.__add__(self.son)
#         print(f"{self.son}+{self.raqam}={qoshish}")
    

# a = math(87)
# a.qoshuv(45)









# UYGA VAZIFA

# class Queue:
#     def __init__(self):
#         self.elementlar = []
#     def qosh(self, element):
#         self.elementlar.append(element)
#         print(f"{element} ro'rxatga qoshildi")
#     def ochir(self):
#         print(f"{self.elementlar[0]} royxatdan ochirildi")
#         self.elementlar.pop(0)
        

# a = Queue()
# a.qosh(12)
# a.qosh(13)
# a.qosh(14)
# a.qosh(15)
# a.qosh(16)
# a.qosh(17)
# print(a.elementlar)
# a.ochir()
# print(a.elementlar)

##########################

# UZbekcha STR

class matn:
    def __init__(self, matn):
        self.soz = matn

    def kattalashtir(self):
        zi = self.soz.upper()
        print(zi)

a = matn()
a.kattalashtir()
 
ab = 'salom'

ab.a.kattalasshtir()





