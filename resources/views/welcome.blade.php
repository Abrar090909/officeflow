@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="row pt-5 pb-4 border-bottom mb-5">
    <div class="col-lg-8 mx-auto text-center">
        <h1 class="display-3 fw-normal text-dark mb-3">Modern Task Management</h1>
        <p class="fs-5 text-muted mb-4 lead">
            A simple, powerful system built for transparency and efficiency. Handle approvals, track progress, and manage documents in one centralized hub.
        </p>
        <div class="d-flex justify-content-center gap-3">
            @guest
                <a href="{{ route('register') }}" class="btn btn-dark btn-lg px-5 py-3 rounded-1 shadow-sm">Get Started Free</a>
                <a href="{{ route('login') }}" class="btn btn-light btn-lg px-5 py-3 rounded-1 border">Sign In</a>
            @else
                <a href="{{ Auth::user()->isManager() ? route('manager.dashboard') : route('employee.dashboard') }}" class="btn btn-dark btn-lg px-5 py-3 rounded-1">Go to Dashboard</a>
            @endguest
        </div>
    </div>
</div>

<!-- Features Section (WordPress Style Cards) -->
<div class="row py-5 bg-white">
    <div class="col-md-12 text-center mb-5">
        <h2 class="fw-bold text-dark">Built for Professional Teams</h2>
        <p class="text-muted">Everything you need to manage your daily office flow.</p>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card h-100 border-top border-4 border-dark rounded-0 shadow-sm p-4 text-center">
            <div class="mb-3 text-dark">
                <i class="bi bi-shield-check fs-1"></i>
            </div>
            <h5 class="fw-bold">Task Approvals</h5>
            <p class="text-muted small mb-0">Streamline the approval process with a transparent feedback loop between managers and employees.</p>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card h-100 border-top border-4 border-primary rounded-0 shadow-sm p-4 text-center">
            <div class="mb-3 text-primary">
                <i class="bi bi-file-earmark-arrow-up fs-1"></i>
            </div>
            <h5 class="fw-bold">File Management</h5>
            <p class="text-muted small mb-0">Securely attach documents, images, and logs directly to tasks for better context and documentation.</p>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card h-100 border-top border-4 border-info rounded-0 shadow-sm p-4 text-center">
            <div class="mb-3 text-info">
                <i class="bi bi-graph-up-arrow fs-1"></i>
            </div>
            <h5 class="fw-bold">REST API Integration</h5>
            <p class="text-muted small mb-0">Built on a full RESTful architecture, allowing for future mobile and third-party integrations.</p>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card h-100 border-top border-4 border-success rounded-0 shadow-sm p-4 text-center">
            <div class="mb-3 text-success">
                <i class="bi bi-kanban fs-1"></i>
            </div>
            <h5 class="fw-bold">Kanban Priority</h5>
            <p class="text-muted small mb-0">Organize your work by High, Medium, and Low priorities to focus on what matters most first.</p>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card h-100 border-top border-4 border-warning rounded-0 shadow-sm p-4 text-center">
            <div class="mb-3 text-warning">
                <i class="bi bi-chat-dots fs-1"></i>
            </div>
            <h5 class="fw-bold">Direct Feedback</h5>
            <p class="text-muted small mb-0">Enable real-time communication between roles via an integrated task commenting system.</p>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card h-100 border-top border-4 border-secondary rounded-0 shadow-sm p-4 text-center">
            <div class="mb-3 text-secondary">
                <i class="bi bi-lock fs-1"></i>
            </div>
            <h5 class="fw-bold">Enterprise Security</h5>
            <p class="text-muted small mb-0">Role-based access control powered by robust horizontal and vertical authorization policies.</p>
        </div>
    </div>
</div>

<!-- Simple Contact Section -->
<div class="row py-5 border-top mt-5">
    <div class="col-md-6 mx-auto text-center border p-5 rounded-1 bg-light">
        <h4 class="fw-bold mb-3">Ready to improve your flow?</h4>
        <p class="text-muted mb-4">Contact our team for a full product demonstration or support.</p>
        <button class="btn btn-dark rounded-1 px-4">Get in Touch</button>
    </div>
</div>
@endsection
