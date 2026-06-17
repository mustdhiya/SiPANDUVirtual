from django.contrib import admin

from apps.dokumen.models import SubmissionDocument, SubmissionReviewHistory, SubmissionRevision


@admin.register(SubmissionDocument)
class SubmissionDocumentAdmin(admin.ModelAdmin):
    list_display = ("title", "guru", "periode", "target_submission", "review_status", "is_video")
    list_filter = ("target_submission", "review_status", "is_video")
    search_fields = ("title", "guru__nama_lengkap")


@admin.register(SubmissionReviewHistory)
class SubmissionReviewHistoryAdmin(admin.ModelAdmin):
    list_display = ("submission_type", "submission_id", "guru", "new_status", "reviewer", "created_at")
    list_filter = ("submission_type", "new_status")
    search_fields = ("guru__nama_lengkap",)


@admin.register(SubmissionRevision)
class SubmissionRevisionAdmin(admin.ModelAdmin):
    list_display = ("submission_type", "submission_id", "guru", "revision_number", "is_resolved")
    list_filter = ("submission_type", "is_resolved")
    search_fields = ("guru__nama_lengkap",)