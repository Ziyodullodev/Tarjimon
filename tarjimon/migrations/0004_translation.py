# Generated by Django 4.0.1 on 2023-03-14 16:07

from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    dependencies = [
        ('tarjimon', '0003_category'),
    ]

    operations = [
        migrations.CreateModel(
            name='translation',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('categoryid', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='tarjimon.category')),
                ('translationid', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, related_name='translation', to='tarjimon.words')),
                ('wordid', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, related_name='word', to='tarjimon.words')),
            ],
        ),
    ]
