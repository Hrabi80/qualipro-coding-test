

export interface Concert {
    id?: number;
    date: Date;
    band_ids: number[];
    party_hall_id: number;
}

export interface ConcertResonse {
    id: number;
    date: Date;
    party_hall_id: number;
    party_hall_name: string;
    bands: BandsInConcert[];
}

interface BandsInConcert{
    id: number;
    name: string;
}