from __future__ import annotations

from django.contrib.auth.forms import AuthenticationForm
from django.contrib.auth.views import LoginView, LogoutView
from django.urls import reverse_lazy
from django.views.generic import TemplateView
from django.contrib import messages

from apps.common.view_mixins import BasePageContextMixin


class LoginPageView(BasePageContextMixin, LoginView):
    template_name = "accounts/login.html"
    authentication_form = AuthenticationForm
    redirect_authenticated_user = True

    def get_success_url(self):
        user = self.request.user
        if hasattr(user, "is_admin_pengawas") and user.is_admin_pengawas:
            return reverse_lazy("dashboard:admin_dashboard")
        return reverse_lazy("dashboard:guru_dashboard")

    def get_breadcrumbs(self):
        return [{"label": "Login"}]

    def form_valid(self, form):
        user = form.get_user()

        if hasattr(user, "can_login") and not user.can_login():
            messages.error(
                self.request,
                "Akun belum bisa digunakan. Pastikan akun sudah disetujui admin dan statusnya aktif."
            )
            return self.form_invalid(form)

        return super().form_valid(form)


class LogoutPageView(LogoutView):
    next_page = reverse_lazy("accounts:login")
    http_method_names = ["post"]

class RegisterPageView(BasePageContextMixin, TemplateView):
    template_name = "accounts/register.html"
    page_title = "Daftar Akun"
    page_subtitle = "Pendaftaran guru binaan"

    def get_breadcrumbs(self):
        return [{"label": "Daftar Akun"}]


class RegistrationSuccessView(BasePageContextMixin, TemplateView):
    template_name = "accounts/registration_success.html"
    page_title = "Pendaftaran Berhasil"

    def get_breadcrumbs(self):
        return [{"label": "Daftar Akun", "url": "/accounts/register/"}, {"label": "Berhasil"}]


class RegistrationQueueView(BasePageContextMixin, TemplateView):
    template_name = "accounts/registration_queue.html"
    page_title = "Antrian Registrasi"
    page_subtitle = "Permintaan akun yang menunggu persetujuan admin"

    def get_breadcrumbs(self):
        return [{"label": "Dashboard", "url": "/dashboard/admin/"}, {"label": "Registrasi Akun"}]

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context["registration_requests"] = [
            {
                "nama_lengkap": "Ahmad Fauzi, S.Pd.I",
                "nip_siaga": "198811112024001",
                "nomor_wa": "081234567890",
                "status": "Menunggu Persetujuan",
            },
            {
                "nama_lengkap": "Nur Aisyah, M.Pd",
                "nip_siaga": "197912212024002",
                "nomor_wa": "081234567891",
                "status": "Cocok dengan master guru",
            },
        ]
        return context