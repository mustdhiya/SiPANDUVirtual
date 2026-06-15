from django.http import HttpResponse
from django.urls import path

app_name = "riset"

def index_view(request):
    return HttpResponse("Riset")

urlpatterns = [
    path("", index_view, name="index"),
]