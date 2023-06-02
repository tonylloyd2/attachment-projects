from django.contrib.auth.models import AbstractBaseUser, BaseUserManager
from django.db import models
from django.contrib.auth.hashers import make_password
class CustomUserManager(BaseUserManager):
    def create_user(self, name, image, password=None):
        if not name:
            raise ValueError("The Name field is required.")
        
        user = self.model(
            name=name,
            image=image,
        )
        user.set_password(password)
        user.save(using=self._db)
        return user

    def create_superuser(self, name, image, password=None):
        user = self.create_user(name, image, password)
        user.is_admin = True
        user.save(using=self._db)
        return user

class CustomUser(AbstractBaseUser):
    name = models.CharField(max_length=255)
    image = models.ImageField(upload_to='user_images/')
    is_active = models.BooleanField(default=True)
    is_admin = models.BooleanField(default=False)

    objects = CustomUserManager()

    USERNAME_FIELD = 'name'
    REQUIRED_FIELDS = ['image']

    def __str__(self):
        return self.name

    def has_perm(self, perm, obj=None):
        return self.is_admin

    def has_module_perms(self, app_label):
        return self.is_admin
class System_users(models.Model):
    name = models.CharField(max_length=255)
    image = models.ImageField(upload_to='user_images/')
    is_active = models.BooleanField(default=True)
    is_admin = models.BooleanField(default=False)
    username = models.CharField(max_length=100)
    password = models.CharField(max_length=128)

    def set_password(self, raw_password):
        self.password = make_password(raw_password)



# class User(models.Model):
    