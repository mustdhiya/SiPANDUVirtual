from django.http import HttpResponse
from django.urls import path

app_name = "konsultasi"

def index_view(request):
    return HttpResponse("Konsultasi")

urlpatterns = [
    path("", index_view, name="index"),
]