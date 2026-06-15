from django.http import HttpResponse
from django.urls import path

app_name = "accounts"

def login_view(request):
    return HttpResponse("Login Page")

def register_view(request):
    return HttpResponse("Register Page")

urlpatterns = [
    path("login/", login_view, name="login"),
    path("register/", register_view, name="register"),
]