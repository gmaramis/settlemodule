# Incident Reporting System Guide

## Overview

The incident reporting system has been designed to guide system-thinking analysis of incidents in clinical settings. It follows international best practices for patient safety reporting and focuses on system-level analysis rather than individual blame.

## Key Features

### 1. Structured Form Fields

The incident reporting form includes the following structured fields:

-   **Date & Time**: When the incident occurred (without patient identifiers)
-   **Clinical Rotation/Department**: Dropdown with 14 medical specialties
-   **Type of Event**: 5 categories of incidents
-   **What Happened**: Free text description with PHI warnings
-   **Why Did It Happen**: System analysis section (key component)
-   **Contributing Factors**: Checkbox selection of 14 common factors
-   **Outcome**: 3 severity levels
-   **Prevention Suggestions**: Free text for improvement recommendations

### 2. System Analysis Framework

The form is designed around the following frameworks:

-   **Swiss Cheese Model**: Multiple layers of defense with holes that aligned
-   **WHO Patient Safety Concepts**: System factors, human factors, and organizational factors
-   **Root Cause Analysis**: Why did each contributing factor exist?
-   **System Thinking**: Focus on processes, not people

### 3. Privacy Protection

-   Clear warnings against including Protected Health Information (PHI)
-   No patient identifiers allowed
-   Focus on system and process analysis

## Available Departments

1. Ilmu Penyakit Dalam (Internal Medicine)
2. Bedah (Surgery)
3. Obstetri dan Ginekologi (Obstetrics & Gynecology)
4. Ilmu Kesehatan Anak (Pediatrics)
5. Anestesiologi & Terapi Intensif (Anesthesiology & Intensive Care)
6. Neurologi (Neurology)
7. Psikiatri (Psychiatry)
8. Ilmu Kedokteran Fisik & Rehabilitasi (Physical Medicine & Rehabilitation)
9. Ilmu Kesehatan Mata (Ophthalmology)
10. Ilmu Penyakit THT-Kepala-Leher (ENT)
11. Dermatovenereologi & Estetika (Dermatology & Aesthetics)
12. Radiologi (Radiology)
13. Forensik & Medikolegal (Forensic & Medico-legal)
14. Ilmu Kedokteran Komunitas (Community Medicine)

## Event Types

1. **Kejadian Sentinel** (Sentinel Event)
2. **Kejadian tidak diharapkan** (Unexpected Event)
3. **Kejadian nyaris cedera** (Near Miss)
4. **Kejadian tidak cedera** (No Harm Event)
5. **Kejadian potensi cedera** (Potential Harm Event)

## Contributing Factors

The system includes 14 common contributing factors:

-   Teamwork
-   Communication
-   Work Environment
-   Task Complexity
-   Supervision
-   Training
-   Equipment
-   Policies & Procedures
-   Workload
-   Fatigue
-   Time Pressure
-   Documentation
-   Patient Factors
-   System Design

## Outcomes

Three outcome categories are available:

-   **No harm**: No adverse effects
-   **Minor Harm**: Minor adverse effects
-   **Significant harm**: Major adverse effects

## Usage Instructions

### For Students

1. Navigate to the "Report New Incident" button
2. Fill out all required fields
3. Pay special attention to the "Why Did It Happen?" section
4. Select relevant contributing factors
5. Provide specific prevention suggestions
6. Submit the report

### For Supervisors/Admins

1. View all incident reports in the index
2. Review individual reports in detail
3. Update status as needed (Under Review, Resolved, Closed)
4. Provide feedback and follow-up actions

## Best Practices

### When Reporting

1. **Be Specific**: Provide detailed descriptions without patient identifiers
2. **Focus on Systems**: Analyze why the incident happened, not who was at fault
3. **Think Prevention**: Suggest concrete improvements
4. **Be Timely**: Report incidents as soon as possible after they occur

### System Analysis Tips

1. **Ask "Why" Five Times**: Dig deeper into root causes
2. **Consider Multiple Factors**: Rarely is there a single cause
3. **Look at Processes**: Focus on how things are done, not who did them
4. **Think Prevention**: What could prevent this from happening again?

## Technical Implementation

### Database Structure

The incidents table includes:

-   `department`: Selected medical specialty
-   `event_type`: Type of incident
-   `event_type_explanation`: Optional additional explanation
-   `what_happened`: Detailed description
-   `why_did_it_happen`: System analysis
-   `contributing_factors`: JSON array of selected factors
-   `outcome`: Severity level
-   `prevention_suggestions`: Improvement recommendations

### Security Features

-   User authentication required
-   Role-based access control
-   PHI warnings and validation
-   Audit trail through activity logging

## Support

For technical support or questions about the incident reporting system, please contact your system administrator or refer to the application documentation.

