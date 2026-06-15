from django.http import HttpResponse
from django.urls import path

app_name = "gudang"

def index_view(request):
    return HttpResponse("Gudang")

urlpatterns = [
    path("", index_view, name="index"),
]