from django.urls import path

from apps.dashboard import views

urlpatterns = [
    path("", views.HomeRedirectView.as_view(), name="home"),
    path("guru/", views.GuruDashboardView.as_view(), name="guru_dashboard"),
    path("admin/", views.AdminDashboardView.as_view(), name="admin_dashboard"),
    path("monitoring/", views.MonitoringListView.as_view(), name="monitoring_list"),
    path("notifications/", views.NotificationListView.as_view(), name="notification_list"),
    path("reports/", views.ReportListView.as_view(), name="report_list"),
    path("siaga/", views.SiagaStatusView.as_view(), name="siaga_status"),
]