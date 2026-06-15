from django.http import HttpResponse
from django.urls import path

app_name = "triwulan"

def index_view(request):
    return HttpResponse("Triwulan")

urlpatterns = [
    path("", index_view, name="index"),
    path("<int:nomor>/", index_view, name="detail"),
]