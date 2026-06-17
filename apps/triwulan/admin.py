from django.contrib import admin

from apps.triwulan.models import SubmissionTW3


@admin.register(SubmissionTW3)
class SubmissionTW3Admin(admin.ModelAdmin):
    list_display = ("guru", "periode", "jml_kehadiran", "status_review", "updated_at")
    list_filter = ("status_review", "periode")
    search_fields = ("guru__nama_lengkap",)