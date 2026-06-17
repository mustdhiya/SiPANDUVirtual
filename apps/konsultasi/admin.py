from django.contrib import admin

from apps.konsultasi.models import ConsultationMessage, ConsultationThread


@admin.register(ConsultationThread)
class ConsultationThreadAdmin(admin.ModelAdmin):
    list_display = ("subject", "guru", "periode", "status", "last_message_at")
    list_filter = ("status",)
    search_fields = ("subject", "guru__nama_lengkap")


@admin.register(ConsultationMessage)
class ConsultationMessageAdmin(admin.ModelAdmin):
    list_display = ("thread", "sender", "is_read", "created_at")
    list_filter = ("is_read",)
    search_fields = ("thread__subject", "sender__username")