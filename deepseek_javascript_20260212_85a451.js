// Smooth Scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Filter Movies
document.querySelectorAll('.filter-btn').forEach(button => {
    button.addEventListener('click', function() {
        // Remove active class from all buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Add active class to clicked button
        this.classList.add('active');
        
        // Filter logic here
        const filter = this.textContent;
        // AJAX request to filter movies
    });
});

// Image Preview for Upload
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const preview = document.getElementById('poster-preview');
            if (preview) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Form Validation
function validateMovieForm() {
    const title = document.querySelector('input[name="title"]').value;
    const description = document.querySelector('textarea[name="description"]').value;
    
    if (title.length < 2) {
        alert('عنوان الفيلم قصير جداً');
        return false;
    }
    
    if (description.length < 20) {
        alert('الرجاء إدخال وصف أطول للفيلم');
        return false;
    }
    
    return true;
}

// Loading Animation
window.addEventListener('load', function() {
    document.body.classList.add('loaded');
});

// Auto-hide Alerts
document.querySelectorAll('.alert').forEach(alert => {
    setTimeout(() => {
        alert.style.opacity = '0';
        setTimeout(() => {
            alert.remove();
        }, 300);
    }, 5000);
});

// Search Functionality
const searchInput = document.getElementById('search-input');
if (searchInput) {
    let searchTimeout;
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        
        searchTimeout = setTimeout(() => {
            const query = this.value;
            if (query.length >= 2) {
                // AJAX search request
                fetch(`search.php?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        // Update movies grid
                        updateMoviesGrid(data);
                    });
            }
        }, 500);
    });
}

function updateMoviesGrid(movies) {
    const grid = document.querySelector('.movies-grid');
    if (!grid) return;
    
    grid.innerHTML = '';
    
    movies.forEach(movie => {
        const card = createMovieCard(movie);
        grid.appendChild(card);
    });
}

function createMovieCard(movie) {
    const card = document.createElement('div');
    card.className = 'movie-card';
    
    card.innerHTML = `
        <div class="movie-poster">
            <img src="${movie.poster_image || 'https://via.placeholder.com/300x450?text=No+Poster'}" 
                 alt="${movie.title}">
            <div class="movie-overlay">
                <a href="movie-details.php?id=${movie.id}" class="btn-play">
                    <i class="fas fa-play"></i>
                </a>
            </div>
            ${movie.rating ? `<span class="rating"><i class="fas fa-star"></i> ${movie.rating}</span>` : ''}
        </div>
        <div class="movie-info">
            <h3>${movie.title}</h3>
            <span class="year">${movie.release_year}</span>
        </div>
    `;
    
    return card;
}