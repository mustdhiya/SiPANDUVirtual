from django.urls import path

from apps.triwulan import views

urlpatterns = [
    path("", views.TriwulanListView.as_view(), name="list"),
    path("tw1/", views.TW1FormView.as_view(), name="tw1"),
    path("tw2/", views.TW2FormView.as_view(), name="tw2"),
    path("tw3/", views.TW3FormView.as_view(), name="tw3"),
    path("tw4/", views.TW4FormView.as_view(), name="tw4"),
]