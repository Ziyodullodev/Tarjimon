# Generated by Django 4.0.1 on 2023-03-14 16:01

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('tarjimon', '0002_words'),
    ]

    operations = [
        migrations.CreateModel(
            name='category',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('name', models.CharField(max_length=20)),
            ],
        ),
    ]
