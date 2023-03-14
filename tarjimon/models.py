from django.db import models

class words(models.Model):
    name = models.TextField('name')
    langId = models.IntegerField()
    transcription = models.CharField('transcription',max_length=255)
    # text_len = models.PositiveIntegerField(blank=True, null=True)

    # def save(self, *args, **kwargs):
    #     self.text_len = len(self.name)
    #     return super(words, self).save(*args, **kwargs)

    def __str__(self):
        return self.name

    def gettranslate(self, *args, **kwargs):
        translate = translation.objects.filter(wordid=self.id)
        if len(translate) > 0:
            return f"{translate[0]}"
        return "non"

class category(models.Model):
    name = models.CharField(max_length=20)

    def __str__(self):
        return self.name    

class translation(models.Model):
    wordid = models.ForeignKey(words,related_name='word', on_delete=models.CASCADE)
    translationid = models.ForeignKey(words,related_name='translation', on_delete=models.CASCADE)
    categoryid = models.ForeignKey(category, on_delete=models.CASCADE)

    def __str__(self):
        return f"{self.translationid}"


