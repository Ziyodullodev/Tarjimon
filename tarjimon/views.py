from django.shortcuts import render
from .models import words, translation

def index(request):
    soz = request.GET.get('q', '')
    if soz != '':
        natija = words.objects.filter(name__contains=soz, langId=0).order_by('name')[:15]
        context = {'q':soz, 'natija':natija, 'langid':0}
        if len(natija) == 0:
            natija = words.objects.filter(name__contains=soz, langId=1).order_by('name')[:15]
            context = {'q':soz, 'natija':natija, 'langid':1}
    else:
        context = {'natija':None}
    return render(request, 'index.html', context=context)
