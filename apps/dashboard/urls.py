from django.http import HttpResponse
from django.urls import path

app_name = "dashboard"

def home_view(request):
    return HttpResponse("Dashboard Home")

urlpatterns = [
    path("", home_view, name="home"),
]