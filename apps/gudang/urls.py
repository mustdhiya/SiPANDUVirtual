from django.urls import path

from apps.gudang import views

urlpatterns = [
    path("", views.MateriListView.as_view(), name="materi_list"),
]