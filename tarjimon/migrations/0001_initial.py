# Generated by Django 3.2.7 on 2021-09-27 08:05

from django.db import migrations, models


class Migration(migrations.Migration):

    initial = True

    dependencies = [
    ]

    operations = [
        migrations.CreateModel(
            name='Lugat',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('ingilizcha', models.CharField(max_length=128, verbose_name='Ingilizcha')),
                ('uzbekcha', models.CharField(max_length=128, verbose_name='O`zbekcha')),
            ],
        ),
    ]
