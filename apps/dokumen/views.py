from __future__ import annotations

from django.views.generic import TemplateView

from apps.common.view_mixins import BasePageContextMixin


class DocumentListView(BasePageContextMixin, TemplateView):
    template_name = "dokumen/document_list.html"
    page_title = "Dokumen Saya"

    def get_breadcrumbs(self):
        return [{"label": "Dokumen"}]

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context["documents"] = [
            {"title": "RPP TW 2", "target_submission": "TW2", "review_status": "LENGKAP", "review_note": "Sesuai"},
            {"title": "Video Pembelajaran", "target_submission": "TW2", "review_status": "REVISI", "review_note": "Audio kurang jelas"},
        ]
        return context


class DocumentUploadView(BasePageContextMixin, TemplateView):
    template_name = "dokumen/document_upload.html"
    page_title = "Upload Dokumen"

    def get_breadcrumbs(self):
        return [{"label": "Dokumen", "url": "/dokumen/"}, {"label": "Upload"}]


class ReviewQueueView(BasePageContextMixin, TemplateView):
    template_name = "dokumen/review_queue.html"
    page_title = "Review Dokumen"

    def get_breadcrumbs(self):
        return [{"label": "Dashboard", "url": "/dashboard/admin/"}, {"label": "Review Dokumen"}]

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context["review_items"] = [
            {"guru": "Ahmad Fauzi", "dokumen": "RPP TW 2", "status": "Pending"},
            {"guru": "Nur Aisyah", "dokumen": "Video Pembelajaran", "status": "Pending"},
        ]
        return context


class RevisionHistoryView(BasePageContextMixin, TemplateView):
    template_name = "dokumen/revision_history.html"
    page_title = "Riwayat Revisi"

    def get_breadcrumbs(self):
        return [{"label": "Dokumen", "url": "/dokumen/"}, {"label": "Riwayat Revisi"}]

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context["revisions"] = [
            {"submission": "TW2", "revision_number": 1, "note_admin": "Perbaiki kualitas audio", "is_resolved": False},
            {"submission": "TW1", "revision_number": 1, "note_admin": "Lengkapi dokumen pendukung", "is_resolved": True},
        ]
        return context