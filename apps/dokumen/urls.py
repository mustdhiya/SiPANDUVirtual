from django.urls import path

from apps.dokumen import views

urlpatterns = [
    path("", views.DocumentListView.as_view(), name="list"),
    path("upload/", views.DocumentUploadView.as_view(), name="upload"),
    path("review/", views.ReviewQueueView.as_view(), name="review_queue"),
    path("revisions/", views.RevisionHistoryView.as_view(), name="revision_history"),
]