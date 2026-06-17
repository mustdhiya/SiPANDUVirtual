from __future__ import annotations

from django.views.generic import TemplateView

from apps.common.view_mixins import BasePageContextMixin


class MateriListView(BasePageContextMixin, TemplateView):
    template_name = "gudang/materi_list.html"
    page_title = "Gudang Materi"

    def get_breadcrumbs(self):
        return [{"label": "Gudang Materi"}]

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context["materi_list"] = [
            {"title": "Panduan TW 1", "kategori": "Panduan", "download_count": 10},
            {"title": "Contoh Dokumen SIAGA", "kategori": "Template", "download_count": 7},
        ]
        return context