from __future__ import annotations

from django.views.generic import TemplateView

from apps.common.view_mixins import BasePageContextMixin


class ThreadListView(BasePageContextMixin, TemplateView):
    template_name = "konsultasi/thread_list.html"
    page_title = "Konsultasi"

    def get_breadcrumbs(self):
        return [{"label": "Konsultasi"}]

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context["threads"] = [
            {"id": 1, "subject": "Konsultasi TW 2", "status": "OPEN", "last_message_at": "Hari ini"},
            {"id": 2, "subject": "Pertanyaan Status SIAGA", "status": "CLOSED", "last_message_at": "Kemarin"},
        ]
        return context


class ThreadDetailView(BasePageContextMixin, TemplateView):
    template_name = "konsultasi/thread_detail.html"
    page_title = "Detail Konsultasi"

    def get_breadcrumbs(self):
        return [{"label": "Konsultasi", "url": "/konsultasi/"}, {"label": "Detail"}]

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context["thread"] = {"subject": "Konsultasi TW 2", "status": "OPEN"}
        context["messages"] = [
            {"sender": "Guru", "message": "Apakah video harus YouTube?", "created_at": "08:00"},
            {"sender": "Admin", "message": "Ya, untuk TW 2 gunakan link YouTube.", "created_at": "08:15"},
        ]
        return context