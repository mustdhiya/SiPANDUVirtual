from __future__ import annotations

from django.views.generic import TemplateView

from apps.common.view_mixins import BasePageContextMixin


class GuruListView(BasePageContextMixin, TemplateView):
    template_name = "master/guru_list.html"
    page_title = "Data Guru"

    def get_breadcrumbs(self):
        return [{"label": "Dashboard", "url": "/dashboard/admin/"}, {"label": "Data Guru"}]

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context["guru_list"] = [
            {"nama_lengkap": "Ahmad Fauzi", "sekolah": "SMA Negeri 1 Samarinda", "tahun_ajaran": "2026/2027"},
            {"nama_lengkap": "Nur Aisyah", "sekolah": "SMK Negeri 2 Samarinda", "tahun_ajaran": "2026/2027"},
        ]
        return context


class SekolahListView(BasePageContextMixin, TemplateView):
    template_name = "master/sekolah_list.html"
    page_title = "Data Sekolah"

    def get_breadcrumbs(self):
        return [{"label": "Dashboard", "url": "/dashboard/admin/"}, {"label": "Data Sekolah"}]

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context["sekolah_list"] = [
            {"nama_sekolah": "SMA Negeri 1 Samarinda", "jenjang": "SMA", "status": "Negeri"},
            {"nama_sekolah": "SMK Negeri 2 Samarinda", "jenjang": "SMK", "status": "Negeri"},
        ]
        return context