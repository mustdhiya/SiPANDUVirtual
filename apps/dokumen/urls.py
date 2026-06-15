from django.http import HttpResponse
from django.urls import path

app_name = "dokumen"

def index_view(request):
    return HttpResponse("Dokumen")

urlpatterns = [
    path("", index_view, name="index"),
]