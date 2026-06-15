from django.utils import timezone

from apps.master.models import PeriodeTriwulan


class TriwulanService:
    @staticmethod
    def get_open_period(nomor: int) -> PeriodeTriwulan | None:
        return (
            PeriodeTriwulan.objects.select_related("tahun_ajaran")
            .filter(
                tahun_ajaran__is_active=True,
                nomor=nomor,
                is_open=True,
            )
            .first()
        )

    @staticmethod
    def is_period_open(periode: PeriodeTriwulan) -> bool:
        return periode.is_open and timezone.now().date() <= periode.deadline