from django.urls import path

from apps.accounts import views

urlpatterns = [
    path("login/", views.LoginPageView.as_view(), name="login"),
    path("logout/", views.LogoutPageView.as_view(), name="logout"),
    path("register/", views.RegisterPageView.as_view(), name="register"),
    path("register/success/", views.RegistrationSuccessView.as_view(), name="registration_success"),
    path("registrations/", views.RegistrationQueueView.as_view(), name="registration_queue"),
]