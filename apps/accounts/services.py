from django.contrib.auth import get_user_model

User = get_user_model()


class AccountService:
    @staticmethod
    def can_user_login(user: User) -> bool:
        return bool(user.is_active and getattr(user, "is_approved", False) and user.status == "ACTIVE")

    @staticmethod
    def approve_user(user: User) -> User:
        user.is_approved = True
        user.status = "ACTIVE"
        user.is_active = True
        user.save(update_fields=["is_approved", "status", "is_active"])
        return user

    @staticmethod
    def reject_user(user: User, suspended: bool = True) -> User:
        user.is_approved = False
        user.status = "SUSPENDED" if suspended else "PENDING"
        user.save(update_fields=["is_approved", "status"])
        return user