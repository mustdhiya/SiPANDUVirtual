from django.urls import path

from apps.master import views

urlpatterns = [
    path("guru/", views.GuruListView.as_view(), name="guru_list"),
    path("sekolah/", views.SekolahListView.as_view(), name="sekolah_list"),
]