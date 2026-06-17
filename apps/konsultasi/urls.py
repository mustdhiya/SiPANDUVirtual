from django.urls import path

from apps.konsultasi import views

urlpatterns = [
    path("", views.ThreadListView.as_view(), name="thread_list"),
    path("<int:pk>/", views.ThreadDetailView.as_view(), name="thread_detail"),
]