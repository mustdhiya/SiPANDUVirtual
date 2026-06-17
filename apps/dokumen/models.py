from __future__ import annotations

from django.db import models

from apps.common.models import BaseModel


class SubmissionDocument(BaseModel):
    TARGET_CHOICES = [
        ("TW1", "TW1"),
        ("TW2", "TW2"),
        ("TW3", "TW3"),
        ("TW4", "TW4"),
    ]

    REVIEW_DOC_CHOICES = [
        ("PENDING", "Pending"),
        ("LENGKAP", "Lengkap"),
        ("REVISI", "Perlu Revisi"),
    ]

    guru = models.ForeignKey(
        "master.GuruBinaan",
        on_delete=models.CASCADE,
        related_name="documents",
    )
    periode = models.ForeignKey(
        "master.PeriodeTriwulan",
        on_delete=models.CASCADE,
        related_name="documents",
    )
    required_document_type = models.ForeignKey(
        "master.RequiredDocumentType",
        on_delete=models.SET_NULL,
        null=True,
        blank=True,
        related_name="documents",
    )
    target_submission = models.CharField(max_length=10, choices=TARGET_CHOICES, db_index=True)
    title = models.CharField(max_length=255)
    file = models.FileField(upload_to="submission/documents/")
    original_filename = models.CharField(max_length=255, blank=True)
    mime_type = models.CharField(max_length=100, blank=True)
    file_size = models.PositiveBigIntegerField(default=0)
    is_video = models.BooleanField(default=False, db_index=True)
    review_status = models.CharField(
        max_length=20,
        choices=REVIEW_DOC_CHOICES,
        default="PENDING",
        db_index=True,
    )
    review_note = models.TextField(blank=True)
    reviewed_at = models.DateTimeField(null=True, blank=True)

    class Meta:
        ordering = ["-created_at"]
        indexes = [
            models.Index(fields=["guru", "periode"]),
            models.Index(fields=["target_submission", "review_status"]),
        ]

    def __str__(self) -> str:
        return self.title

class SubmissionReviewHistory(BaseModel):
    submission_type = models.CharField(max_length=10, db_index=True)
    submission_id = models.PositiveBigIntegerField(db_index=True)
    guru = models.ForeignKey(
        "master.GuruBinaan",
        on_delete=models.CASCADE,
        related_name="review_histories",
    )
    periode = models.ForeignKey(
        "master.PeriodeTriwulan",
        on_delete=models.CASCADE,
        related_name="review_histories",
    )
    previous_status = models.CharField(max_length=20, blank=True)
    new_status = models.CharField(max_length=20, db_index=True)
    note = models.TextField(blank=True)
    reviewer = models.ForeignKey(
        "accounts.CustomUser",
        on_delete=models.SET_NULL,
        null=True,
        blank=True,
        related_name="performed_reviews",
    )

    class Meta:
        ordering = ["-created_at"]
        indexes = [
            models.Index(fields=["submission_type", "submission_id"]),
            models.Index(fields=["guru", "periode"]),
        ]

    def __str__(self) -> str:
        return f"{self.submission_type}-{self.submission_id}"


class SubmissionRevision(BaseModel):
    submission_type = models.CharField(max_length=10, db_index=True)
    submission_id = models.PositiveBigIntegerField(db_index=True)
    guru = models.ForeignKey(
        "master.GuruBinaan",
        on_delete=models.CASCADE,
        related_name="revisions",
    )
    periode = models.ForeignKey(
        "master.PeriodeTriwulan",
        on_delete=models.CASCADE,
        related_name="revisions",
    )
    revision_number = models.PositiveIntegerField(default=1)
    note_admin = models.TextField()
    note_guru = models.TextField(blank=True)
    resolved_at = models.DateTimeField(null=True, blank=True)
    is_resolved = models.BooleanField(default=False, db_index=True)

    class Meta:
        ordering = ["-created_at"]
        unique_together = ("submission_type", "submission_id", "revision_number")
        indexes = [
            models.Index(fields=["guru", "periode", "is_resolved"]),
        ]

    def __str__(self) -> str:
        return f"Rev-{self.revision_number} {self.submission_type}-{self.submission_id}"