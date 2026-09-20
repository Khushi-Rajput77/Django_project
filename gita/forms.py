from django import forms
from gita.models import Reflection


class ReflectionForm(forms.ModelForm):
    class Meta:
        model = Reflection
        fields = ['name', 'verse', 'reflection']

    def clean_name(self):
        name = self.cleaned_data.get('name', '').strip()
        if not name:
            raise forms.ValidationError("Name is required.")
        return name

    def clean_reflection(self):
        reflection = self.cleaned_data.get('reflection', '').strip()
        if not reflection:
            raise forms.ValidationError("Reflection is required.")
        if len(reflection) > 1000:
            raise forms.ValidationError("Reflection is too long (max 1000 characters).")
        return reflection
