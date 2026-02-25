function checkdata() {
	const form = document.parcela;

	if (form.ref_std.value) {
		if (confirm("Este Pagamento é Referente a Este Estúdio?")) {
			form.submit();
		} else {
			return false;
		}
	}
	return true;
}