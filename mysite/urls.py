
from django.contrib import admin
from django.urls import path
from tarjimon.views import index
from django.conf import settings
from django.conf.urls.static import static


urlpatterns = [
    path('admin/', admin.site.urls, name="admin-panel"),
    path('', index, name="tarjimon"),

] + static(settings.STATIC_URL, document_root=settings.STATIC_ROOT)
