from django.contrib import admin

from apps.dashboard.models import MonitoringSnapshot, Notification, SiagaStatusSnapshot


@admin.register(SiagaStatusSnapshot)
class SiagaStatusSnapshotAdmin(admin.ModelAdmin):
    list_display = ("guru", "tahun_ajaran", "status", "mgmp_count", "is_eligible")
    list_filter = ("tahun_ajaran", "status", "is_eligible")
    search_fields = ("guru__nama_lengkap",)


@admin.register(MonitoringSnapshot)
class MonitoringSnapshotAdmin(admin.ModelAdmin):
    list_display = ("guru", "periode", "submission_type", "submission_status", "completion_percentage")
    list_filter = ("submission_type", "submission_status")
    search_fields = ("guru__nama_lengkap",)


@admin.register(Notification)
class NotificationAdmin(admin.ModelAdmin):
    list_display = ("recipient", "title", "level", "channel", "is_read", "sent_at")
    list_filter = ("level", "channel", "is_read")
    search_fields = ("title", "recipient__username")