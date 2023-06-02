from django.urls import path 
from .views import main
from django.conf import settings
from django.conf.urls.static import static

# urlpatterns += 

urlpatterns = [
    path("" ,main ),
    path("home" , main),
    # static(settings.MEDIA_URL, document_root=settings.MEDIA_ROOT)
]
