<?php

/*
 * Page content shared across the site. Edit copy here rather than in the views.
 * Sources: Kafue Group Company Profile 2026 and the website design PDF.
 */
return [

    // Home page "What we supply" cards. Images live in public/images/products/<image>.jpg (Unsplash stock photos).
    'supply' => [
        ['title' => 'Structural steel and plate', 'text' => 'Beams, channels, angles, hollow sections, wear and mild steel plate, cut to size on request.', 'icon' => '<path d="M6 4h12M6 20h12M12 4v16"/>', 'image' => 'steel', 'category' => 'Steel and plate'],
        ['title' => 'Pumps and pump spares', 'text' => 'Slurry, process and dewatering pumps, impellers, liners, mechanical seals and complete rebuild kits.', 'icon' => '<circle cx="9" cy="11" r="3"/><path d="M4 19h16M17 8v6M14 11h6"/>', 'image' => 'pumps', 'category' => 'Pumps and spares'],
        ['title' => 'Pipes, valves and fittings', 'text' => 'HDPE, steel and rubber lined pipe, knife gate, butterfly and check valves, flanges and couplings.', 'icon' => '<rect x="3" y="9" width="5" height="5" rx="1"/><rect x="14" y="9" width="5" height="5" rx="1"/><path d="M8 11.5h6M11 7v4"/>', 'image' => 'pipes', 'category' => 'Pipes and valves'],
        ['title' => 'Wear parts and liners', 'text' => 'Mill liners, crusher wear parts, chute liners, rubber and ceramic lagging for high abrasion duty.', 'icon' => '<rect x="4" y="4" width="16" height="16" rx="2"/><path d="M12 4v16M4 12h16"/>', 'image' => 'wear', 'category' => 'Wear parts and liners'],
        ['title' => 'Electrical and instrumentation', 'text' => 'Cable, switchgear, motors, drives, lighting and field instruments for plant and mine infrastructure.', 'icon' => '<path d="M13 3 6 13h5l-1 8 7-10h-5z"/>', 'image' => 'electrical', 'category' => 'Electrical and instrumentation'],
        ['title' => 'Fasteners and hardware', 'text' => 'High tensile bolts, liner bolts, anchors, gaskets and general hardware in project quantities.', 'icon' => '<circle cx="12" cy="9" r="4"/><path d="M12 13v8M10 21h4"/>', 'image' => 'fasteners', 'category' => 'Fasteners and hardware'],
        ['title' => 'Welding and fabrication supplies', 'text' => 'Welding machines, electrodes, wire, gases, abrasives and cutting tools for workshops and site crews.', 'icon' => '<path d="m14 5 5 5M5 19l8-8M11 7l6 6M13 5l-2 2"/>', 'image' => 'welding', 'category' => 'Welding and fabrication supplies'],
        ['title' => 'Safety and PPE', 'text' => 'Hard hats, boots, gloves, eye and hearing protection, fall arrest and reflective workwear.', 'icon' => '<path d="M4 17a8 8 0 0 1 16 0M3 17h18M12 6v4"/>', 'image' => 'safety', 'category' => 'Safety and PPE'],
        ['title' => 'Lubricants and chemicals', 'text' => 'Greases, gear and hydraulic oils, reagents support, NDT consumables and industrial cleaners.', 'icon' => '<path d="M12 3s6 6.5 6 11a6 6 0 0 1-12 0c0-4.5 6-11 6-11z"/>', 'image' => 'lubricants', 'category' => 'Lubricants and chemicals'],
    ],

    'stages' => [
        ['title' => 'Construction and expansion', 'text' => 'Structural steel, plate, pipe and fittings called off against your construction schedule, with staged deliveries to laydown areas.'],
        ['title' => 'Commissioning', 'text' => 'Pumps, valves, instrumentation and first fill lubricants ready for handover, with spares holdings agreed before start up.'],
        ['title' => 'Operations and maintenance', 'text' => 'Recurring supply of wear parts, consumables and PPE under framework or forward purchasing agreements.'],
        ['title' => 'Shutdowns and breakdowns', 'text' => 'Shutdown kits prepared in advance, and urgent sourcing when critical equipment fails and every hour of downtime counts.'],
    ],

    'steps' => [
        ['title' => 'Receive your RFQ', 'text' => 'Share a BOM, spares list or drawing. We confirm specifications and delivery requirements.'],
        ['title' => 'Source and compare', 'text' => 'We approach qualified manufacturers and give you clear options on price and lead time.'],
        ['title' => 'Inspect and certify', 'text' => 'Goods are checked against specification and shipped with the required documentation.'],
        ['title' => 'Ship and clear', 'text' => 'We manage freight, insurance and customs clearing across borders.'],
        ['title' => 'Deliver to site', 'text' => 'Delivery to your stores or laydown area, with proof of delivery for your records.'],
    ],

    'why' => [
        ['bold' => 'A single point of contact', 'text' => 'for every order, from quotation to proof of delivery.'],
        ['bold' => 'Traceable quality', 'text' => 'with inspection before dispatch and full certification.'],
        ['bold' => 'Consolidated shipments', 'text' => 'that cut handling, paperwork and border delays.'],
        ['bold' => 'Pan African reach', 'text' => 'supplying mining and construction projects across the continent.'],
    ],

    // Company profile: "Eight divisions, one order". Used on the Products page.
    'divisions' => [
        ['title' => 'Steel', 'text' => 'Structural sections, mild, structural and abrasion resistant plate, pipe and tube, reinforcing bar, mesh and ground support. Cut, drilled, coated and tagged to order.'],
        ['title' => 'Tools', 'text' => 'Cordless and corded power tools, professional and insulated hand tools, measuring instruments, abrasives, storage and trade kits.'],
        ['title' => 'Welding and cutting', 'text' => 'Welding machines, electrodes, wire, gases, cutting equipment and weld preparation tools.'],
        ['title' => 'Pumps and flow', 'text' => 'Slurry, process and dewatering pumps, spares, valves, fittings and lined pipe.'],
        ['title' => 'Safety and PPE', 'text' => 'Workwear, boots, gloves, eye, hearing and respiratory protection and fall arrest, with in-house logo branding.'],
        ['title' => 'Lifting', 'text' => 'Chain blocks, lever hoists, slings, shackles and lifting beams, tested and certified.'],
        ['title' => 'Fasteners', 'text' => 'High tensile and liner bolts, anchors, gaskets and hardware in project quantities.'],
        ['title' => 'Lubricants', 'text' => 'Greases, gear and hydraulic oils, NDT consumables and industrial cleaners.'],
    ],

    // Company profile: "Services that keep projects moving". Used on the Services page.
    'services' => [
        ['title' => 'Project supply', 'text' => 'Materials called off against your construction or shutdown programme and staged to site.'],
        ['title' => 'Steel processing', 'text' => 'Cutting, drilling, bevelling, blasting, priming or galvanising and piece tagging.'],
        ['title' => 'Equipment rental', 'text' => 'Welding machines, generators, lighting plants, compressors and rigging, serviced and collected.'],
        ['title' => 'Tool store management', 'text' => 'Staffed on site tool cribs with issue control, replenishment and usage reports.'],
        ['title' => 'Repairs and calibration', 'text' => 'Power tool repairs with loan units and certified calibration of torque and measuring tools.'],
        ['title' => 'Inspection and tagging', 'text' => 'Electrical tool testing and colour coded tagging for site safety audits.'],
        ['title' => 'Urgent sourcing', 'text' => 'A dedicated line for breakdowns and shutdowns, when every hour counts.'],
        ['title' => 'Logistics', 'text' => 'Freight, insurance, customs clearing and delivery to remote sites across Africa.'],
    ],

    'sectors' => [
        ['title' => 'Mining and processing', 'text' => 'Wear steel, pumps, liners, tools, shutdown kits'],
        ['title' => 'Roads, bridges and civil', 'text' => 'Reinforcing, structural steel, lifting gear'],
        ['title' => 'Building and property', 'text' => 'Steel, power tools, fasteners, site supplies'],
        ['title' => 'Energy and power', 'text' => 'Steel structures, electrical, lifting, PPE'],
        ['title' => 'Water and utilities', 'text' => 'Pipe, valves, pumps and fittings'],
        ['title' => 'Industry and manufacturing', 'text' => 'Tools, welding supplies, lubricants'],
    ],

    // Where each division card on the Products page goes: an on-page section, or the quote form with a category.
    'division_links' => [
        'Steel' => ['anchor' => 'steel', 'category' => 'Steel and plate'],
        'Tools' => ['anchor' => 'tools', 'category' => 'Tools and equipment'],
        'Welding and cutting' => ['category' => 'Welding and fabrication supplies'],
        'Pumps and flow' => ['category' => 'Pumps and spares'],
        'Safety and PPE' => ['category' => 'Safety and PPE'],
        'Lifting' => ['category' => 'Lifting equipment'],
        'Fasteners' => ['category' => 'Fasteners and hardware'],
        'Lubricants' => ['category' => 'Lubricants and chemicals'],
    ],

    // Steel division (design page 2). Size ranges are left out until the company confirms them.
    'steel' => [
        'groups' => ['Structural sections', 'Plate and wear steel', 'Pipe and tube', 'Reinforcing and ground support'],
        'table' => [
            ['I and H beams (IPE, UB, UC)', 'S355JR / S275JR', 'Plant structures, conveyor gantries, pipe racks'],
            ['Parallel flange channels', 'S355JR / S275JR', 'Bracing, platforms, chute supports'],
            ['Equal and unequal angles', 'S355JR / S275JR', 'Frames, stairs, handrails, trusses'],
            ['Hollow sections (SHS, RHS, CHS)', 'S355J2H / S275J0H', 'Columns, walkways, trailer and skid frames'],
            ['Flat bar and round bar', 'S355JR / EN8 / EN19', 'Brackets, shafts, pins, general fabrication'],
        ],
        'processing' => [
            ['title' => 'Cut to size', 'text' => 'Plasma, oxy fuel and saw cutting to your cutting list or drawings.'],
            ['title' => 'Drilled and prepared', 'text' => 'Drilling, bevelling and shot blasting before delivery.'],
            ['title' => 'Primed or galvanised', 'text' => 'Coating to your project specification.'],
            ['title' => 'Tagged and bundled', 'text' => 'Marked by piece number so erection crews find it fast.'],
        ],
    ],

    // Tools division (design page 3). Piece counts and prices are left out until the company confirms them.
    'tools' => [
        'highlights' => [
            ['title' => 'Cordless platforms', 'text' => 'Standardise batteries across the crew'],
            ['title' => 'Insulated tools', 'text' => 'Rated for live electrical work'],
            ['title' => 'Calibrated', 'text' => 'Torque and measuring tools with certificates'],
            ['title' => 'Delivered to site', 'text' => 'Across Africa, customs cleared'],
        ],
        'categories' => ['Power tools', 'Hand tools', 'Measuring and test', 'Abrasives and cutting', 'Storage', 'Air and lifting'],
        'power_tools' => [
            ['title' => 'High torque impact wrenches', 'tag' => 'Cordless and pneumatic', 'text' => '1/2 and 3/4 inch drive for liner bolts, heavy fasteners and plant maintenance.'],
            ['title' => 'Drills and impact drivers', 'tag' => 'Cordless', 'text' => 'Hammer drills and drivers for fitting, electrical and construction work.'],
            ['title' => 'Angle grinders', 'tag' => 'Cordless and corded', 'text' => '115 to 230 mm grinders for cutting, grinding and weld preparation.'],
            ['title' => 'Magnetic base drills', 'tag' => 'Corded and cordless', 'text' => 'Portable drilling for structural steel on site.'],
            ['title' => 'Rotary hammers and breakers', 'tag' => 'Corded and cordless', 'text' => 'SDS drilling, chasing and demolition for concrete work.'],
            ['title' => 'Batteries and chargers', 'tag' => 'Platform matched', 'text' => 'Spare packs, fast chargers and multi bay charging stations.'],
        ],
        'kits' => [
            ['title' => 'Electrician', 'text' => 'Insulated VDE tools, multimeter, cable cutters, strippers and testers in a lockable case.'],
            ['title' => 'Fitter and turner', 'text' => 'Spanners, sockets, pullers, measuring tools and files in a roller trolley.'],
            ['title' => 'Boilermaker', 'text' => 'Grinder, hammers, clamps, squares, scribers and marking tools.'],
            ['title' => 'Rigger', 'text' => 'Slings, shackles, tag lines and lifting accessories, inspected and certified.'],
            ['title' => 'Diesel mechanic', 'text' => 'Heavy drive sockets, torque wrench and automotive tools for mobile plant.'],
            ['title' => 'Shutdown crew kit', 'text' => 'Tools for a full shutdown team, delivered before start and collected after.'],
        ],
    ],

    // Buy or rent equipment (design page 2). Used on the Services page.
    'rental' => [
        ['title' => 'Welding machines', 'tag' => 'Buy or rent', 'text' => 'Engine driven, multiprocess and MIG units for site and shutdown crews.'],
        ['title' => 'Generators', 'tag' => 'Buy or rent', 'text' => 'Site power for construction camps, workshops and standby supply.'],
        ['title' => 'Lighting plants', 'tag' => 'Rent', 'text' => 'Mobile towers for night shifts and shutdown work areas.'],
        ['title' => 'Compressors', 'tag' => 'Buy or rent', 'text' => 'Portable air for blasting, tools and maintenance.'],
        ['title' => 'Rigging and lifting', 'tag' => 'Buy or rent', 'text' => 'Chain blocks, slings, shackles and lifting beams, tested and certified.'],
        ['title' => 'Plate and pipe bevellers', 'tag' => 'Rent', 'text' => 'Weld preparation equipment for pipework and heavy fabrication.'],
    ],

    // About page (company profile p2, p5, p6)
    'why_clients' => [
        ['bold' => 'One order, one invoice,', 'text' => 'one consolidated delivery.'],
        ['bold' => 'Steel', 'text' => 'that arrives ready to fabricate.'],
        ['bold' => 'Complete documentation', 'text' => 'with the goods.'],
        ['bold' => 'Buy or rent equipment', 'text' => 'on one account.'],
        ['bold' => 'Urgent sourcing', 'text' => 'for breakdowns and shutdowns.'],
        ['bold' => 'Delivery anywhere in Africa,', 'text' => 'customs cleared.'],
    ],

    'vendor_pack' => [
        'Company registration certificate',
        'Tax clearance certificate',
        'Bank confirmation letter',
        'Quality policy',
        'Safety, health and environment policy',
        'Insurance certificates',
        'Supplier registration numbers',
        'Company profile',
    ],

    'values' => [
        ['title' => 'Reliability', 'text' => 'Delivery dates we can keep, and keep.'],
        ['title' => 'Integrity', 'text' => 'Honest pricing and genuine products.'],
        ['title' => 'Safety', 'text' => 'Products that meet site standards.'],
        ['title' => 'Speed', 'text' => 'Fast quotes and urgent support.'],
        ['title' => 'Partnership', 'text' => 'With clients from groundbreaking to handover.'],
    ],
];
