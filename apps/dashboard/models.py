from __future__ import annotations

from django.db import models

from apps.common.choices import SIAGA_STATUS_CHOICES
from apps.common.models import BaseModel


class SiagaStatusSnapshot(BaseModel):
    guru = models.ForeignKey(
        "master.GuruBinaan",
        on_delete=models.CASCADE,
        related_name="siaga_snapshots",
    )
    tahun_ajaran = models.ForeignKey(
        "master.TahunAjaran",
        on_delete=models.CASCADE,
        related_name="siaga_snapshots",
    )
    status = models.CharField(max_length=40, choices=SIAGA_STATUS_CHOICES, db_index=True)
    mgmp_count = models.PositiveSmallIntegerField(default=0)
    is_eligible = models.BooleanField(default=False, db_index=True)
    note = models.TextField(blank=True)
    calculated_at = models.DateTimeField(auto_now=True)

    class Meta:
        unique_together = ("guru", "tahun_ajaran")
        indexes = [
            models.Index(fields=["tahun_ajaran", "status"]),
        ]

    def __str__(self) -> str:
        return f"{self.guru} - {self.status}"


class MonitoringSnapshot(BaseModel):
    guru = models.ForeignKey(
        "master.GuruBinaan",
        on_delete=models.CASCADE,
        related_name="monitoring_snapshots",
    )
    periode = models.ForeignKey(
        "master.PeriodeTriwulan",
        on_delete=models.CASCADE,
        related_name="monitoring_snapshots",
    )
    submission_type = models.CharField(max_length=10, db_index=True)
    submission_status = models.CharField(max_length=20, db_index=True)
    document_total = models.PositiveIntegerField(default=0)
    document_reviewed = models.PositiveIntegerField(default=0)
    document_revisi = models.PositiveIntegerField(default=0)
    completion_percentage = models.DecimalField(max_digits=5, decimal_places=2, default=0)
    last_activity_at = models.DateTimeField(null=True, blank=True)

    class Meta:
        unique_together = ("guru", "periode", "submission_type")
        indexes = [
            models.Index(fields=["periode", "submission_status"]),
        ]

    def __str__(self) -> str:
        return f"{self.guru} - {self.periode}"
    
class Notification(BaseModel):
    recipient = models.ForeignKey(
        "accounts.CustomUser",
        on_delete=models.CASCADE,
        related_name="notifications",
    )
    title = models.CharField(max_length=255)
    message = models.TextField()
    level = models.CharField(max_length=20, choices=[
        ("INFO", "Info"),
        ("SUCCESS", "Success"),
        ("WARNING", "Warning"),
        ("ERROR", "Error"),
    ], default="INFO", db_index=True)
    channel = models.CharField(max_length=20, choices=[
        ("IN_APP", "In App"),
        ("WHATSAPP", "WhatsApp"),
    ], default="IN_APP", db_index=True)
    target_url = models.CharField(max_length=255, blank=True)
    is_read = models.BooleanField(default=False, db_index=True)
    sent_at = models.DateTimeField(null=True, blank=True)
    read_at = models.DateTimeField(null=True, blank=True)
    error_message = models.TextField(blank=True)

    class Meta:
        ordering = ["-created_at"]
        indexes = [
            models.Index(fields=["recipient", "is_read"]),
            models.Index(fields=["channel", "sent_at"]),
        ]

    def __str__(self) -> str:
        return self.title