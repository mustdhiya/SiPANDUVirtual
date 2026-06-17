from __future__ import annotations

from django.views.generic import RedirectView, TemplateView

from apps.common.view_mixins import BasePageContextMixin


class HomeRedirectView(RedirectView):
    pattern_name = "dashboard:guru_dashboard"


class GuruDashboardView(BasePageContextMixin, TemplateView):
    template_name = "dashboard/guru_dashboard.html"
    page_title = "Dashboard Guru"

    def get_breadcrumbs(self):
        return [{"label": "Dashboard Guru"}]

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context.update({
            "siaga": {"status": "Menunggu Review"},
            "periode_aktif": "TW 2",
            "revisi_count": 2,
            "next_action": "Lengkapi dokumen TW 2 lalu kirim untuk ditinjau admin.",
            "guru": {
                "nama_lengkap": "Ahmad Fauzi, S.Pd.I",
                "nomor_wa": "081234567890",
                "sekolah": {"nama_sekolah": "SMA Negeri 1 Samarinda"},
                "tahun_ajaran": {"label": "2026/2027"},
            },
            "monitoring_items": [
                {"periode": "TW 1", "submission_status": "Lengkap", "completion_percentage": 100},
                {"periode": "TW 2", "submission_status": "Draft", "completion_percentage": 65},
            ],
        })
        return context


class AdminDashboardView(BasePageContextMixin, TemplateView):
    template_name = "dashboard/admin_dashboard.html"
    page_title = "Dashboard Admin"

    def get_breadcrumbs(self):
        return [{"label": "Dashboard Admin"}]

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context.update({
            "total_guru": 66,
            "total_review": 12,
            "total_revisi": 7,
            "total_siap_validasi": 18,
            "pending_registration_count": 4,
            "periode_aktif": {
                "tahun_ajaran": {"label": "2026/2027"},
                "nomor": 2,
                "tema": "Pendampingan Tahap Awal",
                "deadline": "2026-08-31",
            },
        })
        return context


class MonitoringListView(BasePageContextMixin, TemplateView):
    template_name = "dashboard/monitoring_list.html"
    page_title = "Monitoring Guru"

    def get_breadcrumbs(self):
        return [{"label": "Dashboard", "url": "/dashboard/admin/"}, {"label": "Monitoring"}]

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context["monitoring_rows"] = [
            {"nama": "Ahmad Fauzi", "sekolah": "SMA Negeri 1 Samarinda", "tw": "TW 2", "status": "Draft", "progress": 65},
            {"nama": "Nur Aisyah", "sekolah": "SMK Negeri 2 Samarinda", "tw": "TW 2", "status": "Submitted", "progress": 100},
        ]
        return context


class NotificationListView(BasePageContextMixin, TemplateView):
    template_name = "dashboard/notification_list.html"
    page_title = "Notifikasi"

    def get_breadcrumbs(self):
        return [{"label": "Notifikasi"}]

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context["notifications"] = [
            {"title": "Dokumen TW 2 perlu revisi", "message": "Silakan periksa catatan admin.", "level": "WARNING"},
            {"title": "TW 3 telah dibuka", "message": "Anda dapat mulai pengisian TW 3.", "level": "INFO"},
        ]
        return context


class ReportListView(BasePageContextMixin, TemplateView):
    template_name = "dashboard/report_list.html"
    page_title = "Laporan"

    def get_breadcrumbs(self):
        return [{"label": "Dashboard", "url": "/dashboard/admin/"}, {"label": "Laporan"}]

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context["reports"] = [
            {"title": "Rekap TW 1", "period": "2026/2027", "status": "Siap Unduh"},
            {"title": "Monitoring SIAGA", "period": "2026/2027", "status": "Siap Unduh"},
        ]
        return context


class SiagaStatusView(BasePageContextMixin, TemplateView):
    template_name = "dashboard/siaga_status.html"
    page_title = "Status SIAGA"

    def get_breadcrumbs(self):
        return [{"label": "Dashboard", "url": "/dashboard/guru/"}, {"label": "Status SIAGA"}]

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context["siaga"] = {
            "status": "Syarat Belum Terpenuhi",
            "note": "Kehadiran MGMP belum mencapai batas minimal.",
            "mgmp_count": 2,
            "is_eligible": False,
        }
        context["next_action"] = "Ikuti kegiatan MGMP berikutnya dan lengkapi dokumen pembinaan."
        return context