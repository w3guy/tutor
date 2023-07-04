function isTopPortionVisible(element) {
	const rect = element.getBoundingClientRect();
	return rect.top >= 0 && rect.top < window.innerHeight;
}

window.addEventListener('DOMContentLoaded', () => {
	const courseDetails = document.querySelector('.tutor-course-details-page');
	if (courseDetails) {
		const courseSidebar = document.querySelector('.tutor-single-course-sidebar');
		const courseSidebarCard = document.querySelector('.tutor-sidebar-card .tutor-card-body');
		const options = {
			root: null,
			rootMargin: '0px',
			threshold: Array(11)
				.fill()
				.map((_, i) => i * 0.1),
		};

		function observerCallback(entries, observer) {
			entries.forEach((entry) => {
				const isTopVisible = entry.boundingClientRect.top >= 0 && entry.boundingClientRect.top < window.innerHeight;

				courseSidebar.classList.toggle('tutor-sticky', !isTopVisible);
			});
		}

		const observer = new IntersectionObserver(observerCallback, options);
		observer.observe(courseSidebarCard);
	}
});
