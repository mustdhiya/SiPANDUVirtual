from django.http import HttpResponse
from django.urls import path

app_name = "master"

def index_view(request):
    return HttpResponse("Master Data")

urlpatterns = [
    path("", index_view, name="index"),
]