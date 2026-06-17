from __future__ import annotations

from django.views.generic import TemplateView

from apps.common.view_mixins import BasePageContextMixin


class TriwulanListView(BasePageContextMixin, TemplateView):
    template_name = "triwulan/triwulan_list.html"
    page_title = "Triwulan Saya"

    def get_breadcrumbs(self):
        return [{"label": "Triwulan Saya"}]

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context["triwulans"] = [
            {"nomor": 1, "tema": "Perencanaan & Pemetaan", "deadline": "2026-03-31", "review_status": "Lengkap", "status_label": "Selesai"},
            {"nomor": 2, "tema": "Pendampingan Tahap Awal", "deadline": "2026-06-30", "review_status": "Draft", "status_label": "Sedang Dikerjakan"},
            {"nomor": 3, "tema": "Observasi & Umpan Balik", "deadline": "2026-09-30", "review_status": "Belum Mulai", "status_label": "Belum Dibuka"},
            {"nomor": 4, "tema": "Evaluasi & Pelaporan", "deadline": "2026-12-15", "review_status": "Belum Mulai", "status_label": "Belum Dibuka"},
        ]
        return context


class _BaseTWFormView(BasePageContextMixin, TemplateView):
    question_start = 0
    question_end = 0

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context["questions"] = [
            f"Pertanyaan {number}"
            for number in range(self.question_start, self.question_end + 1)
        ]
        return context


class TW1FormView(_BaseTWFormView):
    template_name = "triwulan/tw1_form.html"
    page_title = "TW 1"
    question_start = 12
    question_end = 21

    def get_breadcrumbs(self):
        return [{"label": "Triwulan Saya", "url": "/triwulan/"}, {"label": "TW 1"}]


class TW2FormView(_BaseTWFormView):
    template_name = "triwulan/tw2_form.html"
    page_title = "TW 2"
    question_start = 22
    question_end = 31

    def get_breadcrumbs(self):
        return [{"label": "Triwulan Saya", "url": "/triwulan/"}, {"label": "TW 2"}]


class TW3FormView(_BaseTWFormView):
    template_name = "triwulan/tw3_form.html"
    page_title = "TW 3"
    question_start = 32
    question_end = 41

    def get_breadcrumbs(self):
        return [{"label": "Triwulan Saya", "url": "/triwulan/"}, {"label": "TW 3"}]


class TW4FormView(_BaseTWFormView):
    template_name = "triwulan/tw4_form.html"
    page_title = "TW 4"
    question_start = 42
    question_end = 51

    def get_breadcrumbs(self):
        return [{"label": "Triwulan Saya", "url": "/triwulan/"}, {"label": "TW 4"}]