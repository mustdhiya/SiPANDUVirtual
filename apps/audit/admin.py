from django.contrib import admin

from apps.audit.models import AuditLog


@admin.register(AuditLog)
class AuditLogAdmin(admin.ModelAdmin):
    list_display = ("user", "method", "path", "ip_address", "created_at")
    list_filter = ("method", "created_at")
    search_fields = ("path", "user__username")