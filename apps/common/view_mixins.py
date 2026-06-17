from __future__ import annotations

from typing import Any

from django.views.generic.base import ContextMixin


class BasePageContextMixin(ContextMixin):
    page_title: str = "SiPANDU VIRTUAL"
    page_subtitle: str = ""
    breadcrumbs: list[dict[str, str]] = []

    def get_breadcrumbs(self) -> list[dict[str, str]]:
        return self.breadcrumbs

    def get_sidebar_stats(self) -> dict[str, Any]:
        return {
            "unread_notification_count": 3,
        }

    def get_context_data(self, **kwargs: Any) -> dict[str, Any]:
        context = super().get_context_data(**kwargs)
        context.update(
            {
                "page_title": self.page_title,
                "page_subtitle": self.page_subtitle,
                "breadcrumbs": self.get_breadcrumbs(),
                **self.get_sidebar_stats(),
            }
        )
        return context