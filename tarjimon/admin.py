from django.contrib import admin
from .models import words, category, translation

class WordsAdmin(admin.ModelAdmin):
    list_display = ('name', 'transcription')
    # list_filter = ("name", )
    class Meta:
        ordering = ("name")


class TranslationAdmin(admin.ModelAdmin):

    list_display = ('wordid', 'translationid','categoryid')
    list_filter = ("categoryid",)    

admin.site.register(words, WordsAdmin)
admin.site.register(category)
admin.site.register(translation, TranslationAdmin)
    



