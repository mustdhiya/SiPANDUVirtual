from __future__ import annotations

from django.db import models

from apps.common.choices import REVIEW_STATUS_CHOICES, REVIEW_STATUS_DRAFT
from apps.common.models import BaseModel


class BaseSubmission(BaseModel):
    guru = models.ForeignKey(
        "master.GuruBinaan",
        on_delete=models.CASCADE,
        related_name="%(class)s_items",
    )
    periode = models.ForeignKey(
        "master.PeriodeTriwulan",
        on_delete=models.CASCADE,
        related_name="%(class)s_items",
    )
    status_review = models.CharField(
        max_length=20,
        choices=REVIEW_STATUS_CHOICES,
        default=REVIEW_STATUS_DRAFT,
        db_index=True,
    )
    feedback_admin = models.TextField(blank=True)
    submitted_at = models.DateTimeField(null=True, blank=True)
    reviewed_at = models.DateTimeField(null=True, blank=True)

    class Meta:
        abstract = True


class SubmissionTW1(BaseSubmission):
    status_sekolah = models.CharField(max_length=30, blank=True)
    kelengkapan_mengajar = models.JSONField(default=list, blank=True)

    q12 = models.CharField(max_length=1, blank=True)
    q13 = models.CharField(max_length=1, blank=True)
    q14 = models.CharField(max_length=1, blank=True)
    q15 = models.CharField(max_length=1, blank=True)
    q16 = models.CharField(max_length=1, blank=True)
    q17 = models.CharField(max_length=1, blank=True)
    q18 = models.CharField(max_length=1, blank=True)
    q19 = models.CharField(max_length=1, blank=True)
    q20 = models.CharField(max_length=1, blank=True)
    q21 = models.CharField(max_length=1, blank=True)

    class Meta:
        unique_together = ("guru", "periode")
        indexes = [
            models.Index(fields=["guru", "periode"]),
            models.Index(fields=["status_review"]),
        ]

    def __str__(self) -> str:
        return f"TW1 - {self.guru}"


class SubmissionTW2(BaseSubmission):
    link_video_youtube = models.URLField(blank=True)
    model_pembelajaran = models.TextField(blank=True)
    catatan_metakognitif = models.TextField(blank=True)

    q22 = models.CharField(max_length=1, blank=True)
    q23 = models.CharField(max_length=1, blank=True)
    q24 = models.CharField(max_length=1, blank=True)
    q25 = models.CharField(max_length=1, blank=True)
    q26 = models.CharField(max_length=1, blank=True)
    q27 = models.CharField(max_length=1, blank=True)
    q28 = models.CharField(max_length=1, blank=True)
    q29 = models.CharField(max_length=1, blank=True)
    q30 = models.CharField(max_length=1, blank=True)
    q31 = models.CharField(max_length=1, blank=True)

    class Meta:
        unique_together = ("guru", "periode")
        indexes = [
            models.Index(fields=["guru", "periode"]),
            models.Index(fields=["status_review"]),
        ]

    def __str__(self) -> str:
        return f"TW2 - {self.guru}"


class SubmissionTW3(BaseSubmission):
    KEHADIRAN_CHOICES = [
        (1, "1 Kali"),
        (2, "2 Kali"),
        (3, "3 Kali"),
        (4, "Lebih dari 3 Kali"),
    ]

    jml_kehadiran = models.PositiveSmallIntegerField(choices=KEHADIRAN_CHOICES, default=1)
    resume_pembinaan = models.TextField(blank=True)

    q32 = models.CharField(max_length=1, blank=True)
    q33 = models.CharField(max_length=1, blank=True)
    q34 = models.CharField(max_length=1, blank=True)
    q35 = models.CharField(max_length=1, blank=True)
    q36 = models.CharField(max_length=1, blank=True)
    q37 = models.CharField(max_length=1, blank=True)
    q38 = models.CharField(max_length=1, blank=True)
    q39 = models.CharField(max_length=1, blank=True)
    q40 = models.CharField(max_length=1, blank=True)
    q41 = models.CharField(max_length=1, blank=True)

    class Meta:
        unique_together = ("guru", "periode")
        indexes = [
            models.Index(fields=["guru", "periode"]),
            models.Index(fields=["status_review"]),
        ]

    def __str__(self) -> str:
        return f"TW3 - {self.guru}"


class SubmissionTW4(BaseSubmission):
    skor_karakter = models.DecimalField(max_digits=5, decimal_places=2, null=True, blank=True)
    indikator_json = models.JSONField(default=dict, blank=True)

    q42 = models.CharField(max_length=1, blank=True)
    q43 = models.CharField(max_length=1, blank=True)
    q44 = models.CharField(max_length=1, blank=True)
    q45 = models.CharField(max_length=1, blank=True)
    q46 = models.CharField(max_length=1, blank=True)
    q47 = models.CharField(max_length=1, blank=True)
    q48 = models.CharField(max_length=1, blank=True)
    q49 = models.CharField(max_length=1, blank=True)
    q50 = models.CharField(max_length=1, blank=True)
    q51 = models.CharField(max_length=1, blank=True)

    class Meta:
        unique_together = ("guru", "periode")
        indexes = [
            models.Index(fields=["guru", "periode"]),
            models.Index(fields=["status_review"]),
        ]

    def __str__(self) -> str:
        return f"TW4 - {self.guru}"