from apps.triwulan.models import SubmissionTW3


class SiagaStatusService:
    MIN_KEHADIRAN = 3

    @classmethod
    def get_status(cls, guru, tahun_ajaran) -> str:
        tw3 = (
            SubmissionTW3.objects.filter(
                guru=guru,
                periode__tahun_ajaran=tahun_ajaran,
                status_review="LENGKAP",
            )
            .select_related("periode")
            .first()
        )

        if not tw3:
            return "BELUM_DIBINA"

        if tw3.jml_kehadiran >= cls.MIN_KEHADIRAN:
            return "SIAP_DIVALIDASI"

        return "SYARAT_BELUM_TERPENUHI"