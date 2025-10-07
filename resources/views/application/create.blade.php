<form id="applicationForm" enctype="multipart/form-data">
  @csrf
   <meta name="csrf-token" content="{{ csrf_token() }}">
  <label>Contact Email</label>
  <input type="email" name="contact_email" required>

  <label>Contact Phone</label>
  <input type="text" name="contact_phone" required placeholder="+201234567890">

  <label>Date of Birth</label>
  <input type="date" name="date_of_birth" required>

  <label>Gender</label>
  <select name="gender">
    <option value="">Select</option>
    <option value="male">Male</option>
    <option value="female">Female</option>
    <option value="other">Other</option>
  </select>

  <label>Country</label>
  <input type="text" name="country">

  <label>Files (images & pdf)</label>
  <input type="file" name="files[]" multiple accept=".pdf,image/*">

  <label>Comments</label>
  <textarea name="comments"></textarea>

  <button type="submit">Submit</button>
</form>

<script>
document.getElementById('applicationForm').addEventListener('submit', async function(e) {
  e.preventDefault();
  const form = e.target;
  const fd = new FormData(form);

  const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  try {
    const res = await fetch("{{ route('application.submit') }}", {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': token,
        'Accept': 'application/json'
      },
      body: fd
    });
    const json = await res.json();
    if (res.ok) {
      alert(json.message || 'Submitted');
      form.reset();
    } else {
      // show validation errors
      const errors = json.errors || {};
      alert('Submission failed: ' + (json.message || JSON.stringify(errors)));
    }
  } catch (err) {
    console.error(err);
    alert('An error occurred');
  }
});
</script>
